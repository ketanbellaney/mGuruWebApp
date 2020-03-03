<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Worksheetapi
	Description : Worksheet api for worksheet
	*/
    class Worksheetapi extends MG_Controller {

		var $allboards = array("Andhra Pradesh State Board","Bihar State Board","CBSE","Gujrat State Board","Maharashtra State Board","Rajasthan State Board","Tamil Nadu State Board","West Bengal State Board" );
		var $allclass = array(1,2,3,4,5);
        /*
	    Function name   : __construct()
    	Parameter       : none
    	Return          : none
    	Description     : Constructor  Called as soon as the class instance is created
    	*/
        function __construct() {
            parent::__construct();

            //! Get the current instance
            $this->ci =& get_instance();
        }

		//! Index not required redirect to home page 
        function index() {
            redirect();
        }
        
        //! Get user IP
        function getUserIP() {
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP)) {
				$ip = $client;
			} elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
				$ip = $forward;
			} else {
				$ip = $remote;
			}

			return $ip;
		}
		
		//! Check user monthly limit
		function checkformonthlylimit($user_id,$limit_monthly) {
			$wrr = WorksheetApiRequestResponse::count(array(
				"conditions" => " user_id = '".$user_id."' AND created >= '".date("Y-m-01")." 00:00:00' AND created <= '".date("Y-m-t")." 23:59:59' "
            ));
            
            if($wrr >= $limit_monthly ) {
				return false;
			} else {
				return true;
			}
		}
		
		//! Check user hourly limit
		function checkforhourlylimit($user_id,$limit_hourly) {
			$wrr = WorksheetApiRequestResponse::count(array(
				"conditions" => " user_id = '".$user_id."' AND created >= '".date("Y-m-d H:00:00")."' AND created <= '".date("Y-m-d H:59:59")."' "
            ));
            
            if($wrr >= $limit_hourly ) {
				return false;
			} else {
				return true;
			}
		}

        //! Get all the boards 
        function getallboard() {
			//! Store the response 
			$wrr = WorksheetApiRequestResponse::create(array(
				"request_url" => base_url(uri_string()),
				"request_parameter" => @$_REQUEST['userdata'],
				"ip" => $this->getUserIP(),
				"created" => date("Y-m-d H:i:s"),
			));
			
			
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid format
            if(!isset($api_request->apikey)) {
                $response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update(); 
                die($response_parameter);
            }
            
            $apikey = $api_request->apikey;
            
            $wak = WorksheetApikey::find_apikey($apikey);
            
            if(!isset($wak->id)) {
				$response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter; 
				$wrr->update(); 
                die($response_parameter);
			}
			
			$user_id = $wak->user_id;
			$limit_hourly = $wak->limit_hourly;
			$limit_monthly = $wak->limit_monthly;
			$expire_datetime = $wak->expire_datetime->format("Ymd");
			
			$wrr->user_id = $user_id;
			
			
			//! Check for the expire 
			if(date("Ymd") > $expire_datetime) {
				$response->message = array("Api key expired. Please contact mGuru for renewal.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			//! Check for monthly limit 
			if(!$this->checkformonthlylimit($user_id,$limit_monthly)) {
				$response->message = array("Monthly limit reached. Please contact mGuru to increase monthly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			//! Check for hourly limit 
			if(!$this->checkforhourlylimit($user_id,$limit_hourly)) {
				$response->message = array("Hourly limit reached. Please contact mGuru to increase hourly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			$response->success = true;
			$response->message = array("All board retrieved successfully");
            $response->board = $this->allboards;
            $response_parameter = json_encode($response);
			$wrr->response_parameter = $response_parameter;
			$wrr->update();  
            die($response_parameter);
        }
        
        //! Get all the class 
        function getallclass() {
			//! Store the response 
			$wrr = WorksheetApiRequestResponse::create(array(
				"request_url" => base_url(uri_string()),
				"request_parameter" => @$_REQUEST['userdata'],
				"ip" => $this->getUserIP(),
				"created" => date("Y-m-d H:i:s"),
			));
			
			
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid format
            if(!isset($api_request->apikey)) {
                $response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update(); 
                die($response_parameter);
            }
            
            $apikey = $api_request->apikey;
            
            $wak = WorksheetApikey::find_apikey($apikey);
            
            if(!isset($wak->id)) {
				$response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter; 
				$wrr->update(); 
                die($response_parameter);
			}
			
			$user_id = $wak->user_id;
			$limit_hourly = $wak->limit_hourly;
			$limit_monthly = $wak->limit_monthly;
			$expire_datetime = $wak->expire_datetime->format("Ymd");
			
			$wrr->user_id = $user_id;
			
			
			//! Check for the expire 
			if(date("Ymd") > $expire_datetime) {
				$response->message = array("Api key expired. Please contact mGuru for renewal.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			//! Check for monthly limit 
			if(!$this->checkformonthlylimit($user_id,$limit_monthly)) {
				$response->message = array("Monthly limit reached. Please contact mGuru to increase monthly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			//! Check for hourly limit 
			if(!$this->checkforhourlylimit($user_id,$limit_hourly)) {
				$response->message = array("Hourly limit reached. Please contact mGuru to increase hourly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			$response->success = true;
			$response->message = array("All class retrieved successfully");
            $response->class = $this->allclass;
            $response_parameter = json_encode($response);
			$wrr->response_parameter = $response_parameter;
			$wrr->update();  
            die($response_parameter);
        }
        
        //! Get all the unit for a particular board and class
        function getallunit() {
			//! Store the response
			$wrr = WorksheetApiRequestResponse::create(array(
				"request_url" => base_url(uri_string()),
				"request_parameter" => @$_REQUEST['userdata'],
				"ip" => $this->getUserIP(),
				"created" => date("Y-m-d H:i:s"),
			));
			
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid format
            if(!isset($api_request->apikey)) {
                $response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $apikey = $api_request->apikey;
            
            $wak = WorksheetApikey::find_apikey($apikey);
            
            if(!isset($wak->id)) {
				$response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter; 
				$wrr->update(); 
                die($response_parameter);
			}
			
			$user_id = $wak->user_id;
			$limit_hourly = $wak->limit_hourly;
			$limit_monthly = $wak->limit_monthly;
			$expire_datetime = $wak->expire_datetime->format("Ymd");
			
			$wrr->user_id = $user_id;
            
            if(!isset($api_request->board)) {
                $response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update(); 
                die($response_parameter);
            }

            if(!in_array($api_request->board, $this->allboards)) {
				$response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update(); 
                die($response_parameter);
			}

			if(!isset($api_request->class)) {
                $response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }
            
            if(!in_array($api_request->class, $this->allclass)) {
				$response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update(); 
                die($response_parameter);
			}
            
            //! Check for the expire 
			if(date("Ymd") > $expire_datetime) {
				$response->message = array("Api key expired. Please contact mGuru for renewal.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}

			//! Check for monthly limit 
			if(!$this->checkformonthlylimit($user_id,$limit_monthly)) {
				$response->message = array("Monthly limit reached. Please contact mGuru to increase monthly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();  
                die($response_parameter);
			}
			
			//! Check for hourly limit
			if(!$this->checkforhourlylimit($user_id,$limit_hourly)) {
				$response->message = array("Hourly limit reached. Please contact mGuru to increase hourly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            $dataunits = ConceptsQuestionLinkage::find_by_sql("
            SELECT mg_units.id AS uid, mg_units.name AS uname
            FROM mg_concepts_question_linkage, mg_concepts, mg_units
            WHERE mg_concepts_question_linkage.concepts_id = mg_concepts.id AND
            mg_concepts.units_id = mg_units.id AND
            mg_concepts_question_linkage.classes_id = '".($api_request->class + 2)."' AND
            mg_concepts_question_linkage.board = '".$api_request->board."'
            GROUP by mg_units.id;");

            $response->units = array();

            foreach( $dataunits as $val ) {
                $uni = new stdClass;
                $uni->code = $val->uid;
                $uni->unit = $val->uname;
                $response->units[] = $uni;
            }

			$response->success = true;
			$response->message = array("All units retrieved successfully");
            $response_parameter = json_encode($response);
			$wrr->response_parameter = $response_parameter;
			$wrr->update();  
            die($response_parameter);
        }

        //! Get all the concept for a particular board and class
        function getallconcept() {
			//! Store the response
			$wrr = WorksheetApiRequestResponse::create(array(
				"request_url" => base_url(uri_string()),
				"request_parameter" => @$_REQUEST['userdata'],
				"ip" => $this->getUserIP(),
				"created" => date("Y-m-d H:i:s"),
			));

            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid format
            if(!isset($api_request->apikey)) {
                $response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $apikey = $api_request->apikey;

            $wak = WorksheetApikey::find_apikey($apikey);

            if(!isset($wak->id)) {
				$response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			$user_id = $wak->user_id;
			$limit_hourly = $wak->limit_hourly;
			$limit_monthly = $wak->limit_monthly;
			$expire_datetime = $wak->expire_datetime->format("Ymd");

			$wrr->user_id = $user_id;

            if(!isset($api_request->board)) {
                $response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!in_array($api_request->board, $this->allboards)) {
				$response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			if(!isset($api_request->class)) {
                $response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!in_array($api_request->class, $this->allclass)) {
				$response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            if(!isset($api_request->unit_code)) {
                $response->message = array("Invalid unit code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $unit = Units::find($api_request->unit_code);

            if(!isset($unit->id)) {
				$response->message = array("Invalid unit code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            //! Check for the expire
			if(date("Ymd") > $expire_datetime) {
				$response->message = array("Api key expired. Please contact mGuru for renewal.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			//! Check for monthly limit
			if(!$this->checkformonthlylimit($user_id,$limit_monthly)) {
				$response->message = array("Monthly limit reached. Please contact mGuru to increase monthly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			//! Check for hourly limit
			if(!$this->checkforhourlylimit($user_id,$limit_hourly)) {
				$response->message = array("Hourly limit reached. Please contact mGuru to increase hourly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            $datacons = ConceptsQuestionLinkage::find_by_sql("
              SELECT mg_concepts.id AS cid, mg_concepts.name AS cname
              FROM mg_concepts_question_linkage, mg_concepts
              WHERE mg_concepts_question_linkage.concepts_id = mg_concepts.id AND
              mg_concepts_question_linkage.classes_id = '".($api_request->class + 2)."' AND
              mg_concepts_question_linkage.board = '".$api_request->board."' AND
              mg_concepts.units_id = '".$api_request->unit_code."'
              GROUP by mg_concepts.id;");

            $response->concepts = array();

            foreach( $datacons as $val ) {
                $uni = new stdClass;
                $uni->code = $val->cid;
                $uni->concept = $val->cname;
                $response->concepts[] = $uni;
            }

			$response->success = true;
			$response->message = array("All concepts retrieved successfully");
            $response_parameter = json_encode($response);
			$wrr->response_parameter = $response_parameter;
			$wrr->update();
            die($response_parameter);
        }

        //! Get all the sub concept
        function getallsubconcept() {
			//! Store the response
			$wrr = WorksheetApiRequestResponse::create(array(
				"request_url" => base_url(uri_string()),
				"request_parameter" => @$_REQUEST['userdata'],
				"ip" => $this->getUserIP(),
				"created" => date("Y-m-d H:i:s"),
			));

            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid format
            if(!isset($api_request->apikey)) {
                $response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $apikey = $api_request->apikey;

            $wak = WorksheetApikey::find_apikey($apikey);

            if(!isset($wak->id)) {
				$response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			$user_id = $wak->user_id;
			$limit_hourly = $wak->limit_hourly;
			$limit_monthly = $wak->limit_monthly;
			$expire_datetime = $wak->expire_datetime->format("Ymd");

			$wrr->user_id = $user_id;

            if(!isset($api_request->board)) {
                $response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!in_array($api_request->board, $this->allboards)) {
				$response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			if(!isset($api_request->class)) {
                $response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!in_array($api_request->class, $this->allclass)) {
				$response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            if(!isset($api_request->unit_code)) {
                $response->message = array("Invalid unit code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $unit = Units::find($api_request->unit_code);

            if(!isset($unit->id)) {
				$response->message = array("Invalid unit code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            if(!isset($api_request->concept_code)) {
                $response->message = array("Invalid concept code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $concept = Concepts::find($api_request->concept_code);

            if(!isset($concept->id)) {
				$response->message = array("Invalid concepts code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            //! Check for the expire
			if(date("Ymd") > $expire_datetime) {
				$response->message = array("Api key expired. Please contact mGuru for renewal.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			//! Check for monthly limit
			if(!$this->checkformonthlylimit($user_id,$limit_monthly)) {
				$response->message = array("Monthly limit reached. Please contact mGuru to increase monthly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			//! Check for hourly limit
			if(!$this->checkforhourlylimit($user_id,$limit_hourly)) {
				$response->message = array("Hourly limit reached. Please contact mGuru to increase hourly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            $datacons = ConceptsQuestionLinkage::find_by_sql("
              SELECT mg_question.id AS qid, mg_question.title AS qname, mg_question.level AS qlevel
              FROM mg_concepts_question_linkage, mg_question
              WHERE mg_concepts_question_linkage.question_id = mg_question.id AND
              mg_concepts_question_linkage.classes_id = '".($api_request->class + 2)."' AND
              mg_concepts_question_linkage.board = '".$api_request->board."' AND
              mg_concepts_question_linkage.concepts_id = '".$api_request->concept_code."'
              GROUP by mg_question.id;");

            $response->sub_concepts = array();

            foreach( $datacons as $val ) {
                $uni = new stdClass;
                $uni->code = $val->qid;
                $uni->sub_concept = $val->qname . " - Level: " . $val->qlevel;
                $response->sub_concepts[] = $uni;
            }

			$response->success = true;
			$response->message = array("All sub concepts retrieved successfully");
            $response_parameter = json_encode($response);
			$wrr->response_parameter = $response_parameter;
			$wrr->update();
            die($response_parameter);
        }

        //! Generate math worksheet
        function generateworksheet() {
			//! Store the response
			$wrr = WorksheetApiRequestResponse::create(array(
				"request_url" => base_url(uri_string()),
				"request_parameter" => @$_REQUEST['userdata'],
				"ip" => $this->getUserIP(),
				"created" => date("Y-m-d H:i:s"),
			));

            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid format
            if(!isset($api_request->apikey)) {
                $response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $apikey = $api_request->apikey;

            $wak = WorksheetApikey::find_apikey($apikey);

            if(!isset($wak->id)) {
				$response->message = array("Invalid api key.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			$user_id = $wak->user_id;
			$limit_hourly = $wak->limit_hourly;
			$limit_monthly = $wak->limit_monthly;
			$expire_datetime = $wak->expire_datetime->format("Ymd");

			$wrr->user_id = $user_id;

            if(!isset($api_request->board)) {
                $response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!in_array($api_request->board, $this->allboards)) {
				$response->message = array("Invalid board.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			if(!isset($api_request->class)) {
                $response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!in_array($api_request->class, $this->allclass)) {
				$response->message = array("Invalid class.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            if(!isset($api_request->name)) {
                $response->message = array("Invalid Worksheet name.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!isset($api_request->questions)) {
                $response->message = array("Invalid questions.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            if(!is_array($api_request->questions)) {
                $response->message = array("Invalid questions format.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }




            

            if(!isset($api_request->unit_code)) {
                $response->message = array("Invalid unit code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $unit = Units::find($api_request->unit_code);

            if(!isset($unit->id)) {
				$response->message = array("Invalid unit code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            if(!isset($api_request->concept_code)) {
                $response->message = array("Invalid concept code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
            }

            $concept = Concepts::find($api_request->concept_code);

            if(!isset($concept->id)) {
				$response->message = array("Invalid concepts code.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            //! Check for the expire
			if(date("Ymd") > $expire_datetime) {
				$response->message = array("Api key expired. Please contact mGuru for renewal.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			//! Check for monthly limit
			if(!$this->checkformonthlylimit($user_id,$limit_monthly)) {
				$response->message = array("Monthly limit reached. Please contact mGuru to increase monthly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

			//! Check for hourly limit
			if(!$this->checkforhourlylimit($user_id,$limit_hourly)) {
				$response->message = array("Hourly limit reached. Please contact mGuru to increase hourly limit.");
                $response_parameter = json_encode($response);
				$wrr->response_parameter = $response_parameter;
				$wrr->update();
                die($response_parameter);
			}

            $datacons = ConceptsQuestionLinkage::find_by_sql("
              SELECT mg_question.id AS qid, mg_question.title AS qname, mg_question.level AS qlevel
              FROM mg_concepts_question_linkage, mg_question
              WHERE mg_concepts_question_linkage.question_id = mg_question.id AND
              mg_concepts_question_linkage.classes_id = '".($api_request->class + 2)."' AND
              mg_concepts_question_linkage.board = '".$api_request->board."' AND
              mg_concepts_question_linkage.units_id = '".$api_request->unit_code."' AND
              mg_concepts_question_linkage.concepts_id = '".$api_request->concept_code."'
              GROUP by mg_question.id;");

            $response->sub_concepts = array();

            foreach( $datacons as $val ) {
                $uni = new stdClass;
                $uni->code = $val->qid;
                $uni->sub_concept = $val->qname . " - Level: " . $val->qlevel;
                $response->sub_concepts[] = $uni;
            }

			$response->success = true;
			$response->message = array("All sub concepts retrieved successfully");
            $response_parameter = json_encode($response);
			$wrr->response_parameter = $response_parameter;
			$wrr->update();
            die($response_parameter);
        }

	}
?>