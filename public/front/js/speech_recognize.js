if ('SpeechRecognition' in window) {

    var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
    var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList
    var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent

    var colors = [''];
    var grammar = '#JSGF V1.0; grammar colors; public <color> = ' + colors.join(' | ') + ' ;'

    var recognition = new SpeechRecognition();
    var speechRecognitionList = new SpeechGrammarList();
    speechRecognitionList.addFromString(grammar, 1);
    recognition.grammars = speechRecognitionList;
    recognition.continuous = false;
    recognition.lang = (LANGUAGE == 'en') ? 'en-US' : 'ar-QA';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    var diagnostic = document.querySelector('#description');

    $('#voice_microphone').click(function(){
        recognition.start();
        $('#voice_microphone').hide();
        console.log('Ready to receive a color command.');
    });



    recognition.onresult = function(event) {
        // The SpeechRecognitionEvent results property returns a SpeechRecognitionResultList object
        // The SpeechRecognitionResultList object contains SpeechRecognitionResult objects.
        // It has a getter so it can be accessed like an array
        // The first [0] returns the SpeechRecognitionResult at the last position.
        // Each SpeechRecognitionResult object contains SpeechRecognitionAlternative objects that contain individual results.
        // These also have getters so they can be accessed like arrays.
        // The second [0] returns the SpeechRecognitionAlternative at position 0.
        // We then return the transcript property of the SpeechRecognitionAlternative object
        var color = event.results[0][0].transcript;
        $('#description').val(color);
    }

    recognition.onspeechend = function() {
        recognition.stop();
        $('#voice_microphone').show();
    }

    recognition.onnomatch = function(event) {
        diagnostic.textContent = "I didn't recognise that color.";
    }

    recognition.onerror = function(event) {
        diagnostic.textContent = 'Error occurred in recognition: ' + event.error;
        console.log('speech error'+ event.error);
    }

} else {
    console.log('speech not supported')
}



