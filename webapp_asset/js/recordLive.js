var audio_context,
    recorder,
    volume,
    volumeLevel = 0,
    currentEditedSoundIndex;

function startUserMedia(stream) {
  var input = audio_context.createMediaStreamSource(stream);
  console.log('Media stream created.');

  volume = audio_context.createGain();
  volume.gain.value = volumeLevel;
  input.connect(volume);
  volume.connect(audio_context.destination);
  console.log('Input connected to audio context destination.');
  
  recorder = new Recorder(input);
  console.log('Recorder initialised.');
}


/*function startRecording(button) {
    volumeLevel = 0.7,
  recorder && recorder.record();
  button.disabled = true;
  button.nextElementSibling.disabled = false;
  console.log('Recording...');
}

function stopRecording(button) {
    volumeLevel = 0,
  recorder && recorder.stop();
  button.disabled = true;
  button.previousElementSibling.disabled = false;
  console.log('Stopped recording.');

  // create WAV download link using audio data blob
  createDownloadLink();

  recorder.clear();
} */

function startRecording() {
    volumeLevel = 0.7,
    recorder && recorder.record();
    console.log('Recording...');
}

function stopRecording() {
    volumeLevel = 0,
    recorder && recorder.stop();
    console.log('Stopped recording.');

    // create WAV download link using audio data blob
    createDownloadLink();

    recorder.clear();
}

function createDownloadLink() {
  currentEditedSoundIndex = -1;
  recorder && recorder.exportWAV(handleWAV.bind(this));
}

function handleWAV(blob) {
  document.getElementById('recordingslist').innerHTML = '';
  var tableRef = document.getElementById('recordingslist');

  var url = URL.createObjectURL(blob);
  //var newRow   = tableRef.insertRow(currentEditedSoundIndex);
  //newRow.className = 'soundBite';
  var audioElement = document.createElement('audio');
  audioElement.id = 'recorded_audio_id'
  //var downloadAnchor = document.createElement('a');
  //var editButton = document.createElement('button');
  
  audioElement.controls = false;
  audioElement.src = url;



  tableRef.appendChild(audioElement);
}

function playrecodring() {
    var audioo = document.getElementById('recorded_audio_id');
    audioo.play();
}

function stopplayrecodring() {
    var audioo = document.getElementById('recorded_audio_id');
    audioo.pause();
    audioo.currentTime = 0;
}

window.onload = function init() {
  try {
    // webkit shim
    window.AudioContext = window.AudioContext || window.webkitAudioContext || window.mozAudioContext;
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    window.URL = window.URL || window.webkitURL || window.mozURL;
    
    audio_context = new AudioContext();
    console.log('Audio context set up.');
    console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
  } catch (e) {
    console.warn('No web audio support in this browser!');
  }
  
  navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
    console.warn('No live audio input: ' + e);
  });
};