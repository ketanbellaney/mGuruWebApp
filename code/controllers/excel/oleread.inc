<?php

define('NUM_BIG_BLOCK_DEPOT_BLOCKS_POS', 0x2c);     //44
define('SMALL_BLOCK_DEPOT_BLOCK_POS', 0x3c);        //60
define('ROOT_START_BLOCK_POS', 0x30);               //48
define('BIG_BLOCK_SIZE', 0x200);                    //512
define('SMALL_BLOCK_SIZE', 0x40);                   //64
define('EXTENSION_BLOCK_POS', 0x44);                //68
define('NUM_EXTENSION_BLOCK_POS', 0x48);            //72
define('PROPERTY_STORAGE_BLOCK_SIZE', 0x80);        //128
define('BIG_BLOCK_DEPOT_BLOCKS_POS', 0x4c);         //76
define('SMALL_BLOCK_THRESHOLD', 0x1000);            //4096
// property storage offsets
define('SIZE_OF_NAME_POS', 0x40);                   //64
define('TYPE_POS', 0x42);                           //66
define('START_BLOCK_POS', 0x74);                    //116
define('SIZE_POS', 0x78);                           //120
define('IDENTIFIER_OLE', pack("CCCCCCCC",0xd0,0xcf,0x11,0xe0,0xa1,0xb1,0x1a,0xe1));

//echo 'ROOT_START_BLOCK_POS = '.ROOT_START_BLOCK_POS."\n";

//echo bin2hex($data[ROOT_START_BLOCK_POS])."\n";
//echo "a=";
//echo $data[ROOT_START_BLOCK_POS];
//function log

function GetInt4d($data, $pos)
{

$_or_24 = ord($data[$pos+3]);

if ($_or_24>=128)
$_ord_24 = -abs((256-$_or_24) << 24);
else
$_ord_24 = ($_or_24&127) << 24;

return ord($data[$pos]) | (ord($data[$pos+1]) << 8) | (ord($data[$pos+2]) << 16) | $_ord_24;

 //       return ord($data[$pos]) | (ord($data[$pos+1]) << 8) | (ord($data[$pos+2]) << 16) | (ord($data[$pos+3]) << 24);
}


class OLERead
{
    var $data = '';

    function OLERead()
    {

    }
    
    function read($sFileName)
    {

    	// check if file exist and is readable (Darko Miljanovic)
    	if(!is_readable($sFileName))
        {
    		$this->error = 1;
    		return false;
    	}

    	$this->data = @file_get_contents($sFileName);   //Get whole excel sheet raw data
  //      echo strlen($this->data);
 //       echo $this->data;

        if (!$this->data)
        {
    		$this->error = 1; 
    		return false; 
   		}
   		//echo IDENTIFIER_OLE;
   		//echo 'start';

   		if (substr($this->data, 0, 8) != IDENTIFIER_OLE)
        {
    		$this->error = 1; 
    		return false; 
   		}

        $this->numBigBlockDepotBlocks = GetInt4d($this->data, NUM_BIG_BLOCK_DEPOT_BLOCKS_POS);
        $this->sbdStartBlock = GetInt4d($this->data, SMALL_BLOCK_DEPOT_BLOCK_POS);
        $this->rootStartBlock = GetInt4d($this->data, ROOT_START_BLOCK_POS);
        $this->extensionBlock = GetInt4d($this->data, EXTENSION_BLOCK_POS);
        $this->numExtensionBlocks = GetInt4d($this->data, NUM_EXTENSION_BLOCK_POS);

 /*
 echo $this->numBigBlockDepotBlocks."<br>";                          1
        echo $this->sbdStartBlock." <br>";                                          -2
        echo $this->rootStartBlock."<br> ";                                         25
        echo $this->extensionBlock." <br>";                                         -2
        echo $this->numExtensionBlocks." <br>";                                     0
 */
        //echo "sbdStartBlock = $this->sbdStartBlock\n";

        $bigBlockDepotBlocks = array();

        $pos = BIG_BLOCK_DEPOT_BLOCKS_POS;
       // echo "pos = $pos";
	    $bbdBlocks = $this->numBigBlockDepotBlocks;
        
        if ($this->numExtensionBlocks != 0)
        {
            $bbdBlocks = (BIG_BLOCK_SIZE - BIG_BLOCK_DEPOT_BLOCKS_POS)/4;
        }
        
        for ($i = 0; $i < $bbdBlocks; $i++)
        {
            $bigBlockDepotBlocks[$i] = GetInt4d($this->data, $pos);
      //      echo $bigBlockDepotBlocks[$i];
            $pos += 4;
        }
        
        
        for ($j = 0; $j < $this->numExtensionBlocks; $j++)
        {
            $pos = ($this->extensionBlock + 1) * BIG_BLOCK_SIZE;
            $blocksToRead = min($this->numBigBlockDepotBlocks - $bbdBlocks, BIG_BLOCK_SIZE / 4 - 1);

            for ($i = $bbdBlocks; $i < $bbdBlocks + $blocksToRead; $i++)
            {
                $bigBlockDepotBlocks[$i] = GetInt4d($this->data, $pos);
     //           echo $bigBlockDepotBlocks[$i] . "<br>";
                $pos += 4;
            }   

            $bbdBlocks += $blocksToRead;
            if ($bbdBlocks < $this->numBigBlockDepotBlocks)
            {
                $this->extensionBlock = GetInt4d($this->data, $pos);
            }
        }

       // var_dump($bigBlockDepotBlocks);
        
        // readBigBlockDepot
        $pos = 0;
        $index = 0;
        $this->bigBlockChain = array();
        
        for ($i = 0; $i < $this->numBigBlockDepotBlocks; $i++)
        {
            $pos = ($bigBlockDepotBlocks[$i] + 1) * BIG_BLOCK_SIZE;
            //echo "pos = $pos";
            for ($j = 0 ; $j < BIG_BLOCK_SIZE / 4; $j++)
            {
                $this->bigBlockChain[$index] = GetInt4d($this->data, $pos);
  //              echo "$index  --  $this->bigBlockChain[$index] -- GetInt4d($this->data, $pos) <br>";
                $pos += 4 ;
                $index++;
            }
        }

	//var_dump($this->bigBlockChain);
        //echo '=====2';
        // readSmallBlockDepot();
        $pos = 0;
	    $index = 0;
	    $sbdBlock = $this->sbdStartBlock;
	    $this->smallBlockChain = array();
	
	    while ($sbdBlock != -2)
        {
	      $pos = ($sbdBlock + 1) * BIG_BLOCK_SIZE;

	      for ($j = 0; $j < BIG_BLOCK_SIZE / 4; $j++)
          {
	        $this->smallBlockChain[$index] = GetInt4d($this->data, $pos);
	        $pos += 4;
	        $index++;
	      }

	      $sbdBlock = $this->bigBlockChain[$sbdBlock];
	    }


        // readData(rootStartBlock)
        $block = $this->rootStartBlock;
        $pos = 0;
        $this->entry = $this->__readData($block);
        
        /*
        while ($block != -2)  {
            $pos = ($block + 1) * BIG_BLOCK_SIZE;
            $this->entry = $this->entry.substr($this->data, $pos, BIG_BLOCK_SIZE);
            $block = $this->bigBlockChain[$block];
        }
        */
        //echo '==='.$this->entry."===";
        $this->__readPropertySets();

    }

     function __readData($bl)
     {
        $block = $bl;
        $pos = 0;
        $data = '';

        while ($block != -2)
        {
            $pos = ($block + 1) * BIG_BLOCK_SIZE;
            $data = $data.substr($this->data, $pos, BIG_BLOCK_SIZE);
          //  echo "pos = $pos data=$data\n";
     //     echo "$block <br>";
    	    $block = $this->bigBlockChain[$block];
     //       echo "$block <br>";
        }
		return $data;
     }

    function __readPropertySets()
    {
        $offset = 0;
        //var_dump($this->entry);
 //       echo " Length of The Entry ".strlen($this->entry)."<br>";
        // Get Length of XYZ
        // Traverse Through The Length
        while ($offset < strlen($this->entry))
        {
              // Get values Between X and Y; Y = End , X is Traversal Point
              $d = substr($this->entry, $offset, PROPERTY_STORAGE_BLOCK_SIZE);
//              echo "The ASCII VALUE IS ".ord($d);
              $nameSize = ord($d[SIZE_OF_NAME_POS]) | (ord($d[SIZE_OF_NAME_POS+1]) << 8);
   //           echo "The Name size is ".$nameSize."<br>";
              $type = ord($d[TYPE_POS]);
     //         echo "The Type is ".$type."<br>";
              //$maxBlock = strlen($d) / BIG_BLOCK_SIZE - 1;

              $startBlock = GetInt4d($d, START_BLOCK_POS);
       //       echo "The Startblock is ".$startBlock."<br>";
              $size = GetInt4d($d, SIZE_POS);
         //     echo "The Size is ".$size."<br>";

            $name = '';
            for ($i = 0; $i < $nameSize ; $i++)
            {
              $name .= $d[$i];
            }
           // echo "The Name is ".$name."<br>";

            $name = str_replace("\x00", "", $name);
  //          echo "$name <br> $type <br> $startBlock <br> $size <br><br> ";

//  echo "The Modified Name is ".$name."<br>";
            $this->props[] = array (
                'name' => $name,
                'type' => $type,
                'startBlock' => $startBlock,
                'size' => $size);

          //  echo $name ."<br>";
            if (($name == "Workbook") || ($name == "Book"))
            {
                $this->wrkbook = count($this->props) - 1;
       //         echo $this->wrkbook;
            }

            if ($name == "Root Entry")
            {
                $this->rootentry = count($this->props) - 1;
            }

            //echo "name ==$name=\n";

            $offset += PROPERTY_STORAGE_BLOCK_SIZE;

        }// While

 //             echo " The Workbook is ".$this->wrkbook."<br>";
   //           echo " The RootEntry is ".$this->rootentry."<br>";

    }


    function getWorkBook()
    {
    	if ($this->props[$this->wrkbook]['size'] < SMALL_BLOCK_THRESHOLD)
        {
//    	  getSmallBlockStream(PropertyStorage ps)
 //           echo $this->props[$this->rootentry]['startBlock'];
			$rootdata = $this->__readData($this->props[$this->rootentry]['startBlock']);

			$streamData = '';
	        $block = $this->props[$this->wrkbook]['startBlock'];
        //    echo $block;
	        //$count = 0;
	        $pos = 0;
		    while ($block != -2)
            {
      	          $pos = $block * SMALL_BLOCK_SIZE;
		          $streamData .= substr($rootdata, $pos, SMALL_BLOCK_SIZE);

			      $block = $this->smallBlockChain[$block];
		    }
	//		 echo "$streamData <br>";
		    return $streamData;
    		

    	}else{
    	
	        $numBlocks = $this->props[$this->wrkbook]['size'] / BIG_BLOCK_SIZE;
	        if ($this->props[$this->wrkbook]['size'] % BIG_BLOCK_SIZE != 0)
            {
	            $numBlocks++;
	        }
	        
	        if ($numBlocks == 0) return '';
	        
	        //echo "numBlocks = $numBlocks\n";
	    //byte[] streamData = new byte[numBlocks * BIG_BLOCK_SIZE];
	        //print_r($this->wrkbook);
	        $streamData = '';
	        $block = $this->props[$this->wrkbook]['startBlock'];
	        //$count = 0;
	        $pos = 0;
	        //echo "block = $block";
	        while ($block != -2) {
	          $pos = ($block + 1) * BIG_BLOCK_SIZE;
	          $streamData .= substr($this->data, $pos, BIG_BLOCK_SIZE);
	          $block = $this->bigBlockChain[$block];
  //            echo "$streamData <br>";
	        }

	    //    echo 'stream'.$streamData ;
	        return $streamData;
    	}
    }
    
}
?>