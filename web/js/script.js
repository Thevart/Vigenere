$(function(){
    $(document).on('click', '#exercice2Submit', function(e) {
        var mytext = document.getElementById('exercice2Text').value;
        var array = { text : mytext};
        sendRequest(array, "/index.php/tolower", 'exercice2Result');
    });
    $(document).on('click', '#exercice3Submit', function(e) {
        var letter1 = document.getElementById('exercice3Letter1').value;
        var letter2 = document.getElementById('exercice3Letter2').value;
        var array = { char1: letter1, char2:letter2 };
        sendRequest(array, "/index.php/getCharInversion","exercice3Result");
    });
    $(document).on('click', '#exercice4Submit', function(e) {
        var mytext1 = document.getElementById('exercice4Text1').value;
        var mytext2 = document.getElementById('exercice4Text2').value;
        var array = { text1: mytext1, text2: mytext2};
        sendRequest(array, "/index.php/getVigenereEncryption","exercice4Result");
    });

    $(document).on('click', '#exercice5Submit', function(e) {
        var mytext1 = document.getElementById('exercice5Text1').value;
        var mytext2 = document.getElementById('exercice5Text2').value;
        var array = { text1: mytext1, text2: mytext2};
        sendRequest(array, "/index.php/getVigenereDecryption","exercice5Result");
    });
    $(document).on('click', '#exercice6Submit', function(e) {
        var mytext = document.getElementById('exercice6Text').value;
        var array = { cipher: mytext};
        sendRequest(array, "/index.php/getCipherOccurence","exercice6Result");
    });
    $(document).on('click', '#exercice8Submit', function(e) {
        var mytext = document.getElementById('exercice8Text').value;
        var array = { cipher: mytext};
        sendRequest(array, "/index.php/getCleanedCipherOccurence","exercice8Result");
    });
    $(document).on('click', '#exercice15Submit', function(e) {
        var mycipher = document.getElementById('exercice15Cipher').value;
        var myposition = document.getElementById('exercice15Position').value;
        var myPB = document.getElementById('exercice15ProbableWord').value;
        var array = { cipher: mycipher, position:myposition, probableWord:myPB};
        sendRequest(array, "/index.php/getPossibleKey","exercice15Result");
    });
    $(document).on('click', '#exercice16Submit', function(e) {
        var mycipher = document.getElementById('exercice16Cipher').value;
        var myPB = document.getElementById('exercice16ProbableWord').value;
        var array = { cipher: mycipher, probableWord:myPB};
        sendRequest(array, "/index.php/getAllPossibleKey","exercice16Result");
    });
});

function sendRequest(data, url, resultDiv){

    console.log('Submitting request');
    console.log(data);
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        //dataType: "json",
        success: function(data){
            console.log(data);
            displayDataInDiv(resultDiv, data);
        },
        fail:function(data) {
            console.log(data);
        }
    });
}

function displayDataInDiv(id, data){
    document.getElementById(id).innerHTML = data;
}