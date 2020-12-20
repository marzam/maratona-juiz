function forgot_password(){
    document.getElementById("id_login").action = 'forgot.php';
    document.getElementById('id_login').submit();
}
//------------------------------------------------------------------
function delete_cookie(cookie_name){
    var cookie_date = new Date ( );  // current date & time
    cookie_date.setTime (cookie_date.getTime() - 1);
    document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}

function logout(){
  delete_cookie('login-team');
   window.open("login.php", "_self");
}

//------------------------------------------------------------------

function readBody(xhr) {
    var data;
    if (!xhr.responseType || xhr.responseType === "text") {
        data = xhr.responseText;
    } else if (xhr.responseType === "document") {
        data = xhr.responseXML;
    } else {
        data = xhr.response;
    }
    return data;
  }
  
  function setSelect(index){
      //document.getElementById("myText").select();
    var idelement = 'id_updated_' + index.toString();
      document.getElementById(idelement).value = '1';
    
  }



  function pInfo(index){
    var info_id  = 'id_info_' + index.toString();
    var info_text = document.getElementById(info_id).value;
    var output = prompt("info:", info_text);
    document.getElementById(info_id).value = output;
    var idelement = 'id_updated_' + index.toString();
    document.getElementById(idelement).value = '1';



  }

function isNumberKey(evt, index){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    var idelement = 'id_updated_' + index.toString();

    document.getElementById(idelement).value = '1';

    if ( ((charCode >= 48) && (charCode <= 57)) || (charCode == 46))
        return true;
    return false;
}

function updateSubmissionsXML(){
    var doc = document.implementation.createDocument("", "", null);
    var record = doc.createElement("record");
    var data = doc.createElement("data");
    
    var mIndex = document.getElementById('id_index_value').value;
    //alert('update:' + mIndex.toString());
    var flag = 0;
    //id_updated_
    for (var i = 0; i < mIndex; i++){
      var id = 'id_updated_' +  i.toString();
      var opt = document.getElementById(id).value;
      var recID = '';
      var recAnswer = '';
      var recElapsedtime = '';
      
      if (opt == '1'){
        flag = 1;
        var data = doc.createElement("data");
        recID           = document.getElementById('id_submissionID_' +  i.toString()).value;
        recAnswer       = document.getElementById('id_answser_' +  i.toString()).value;
        recElapsedtime  = document.getElementById('id_elapsedtime_' +  i.toString()).value;
        recPElapsedtime = document.getElementById('id_p_elapsedtime_' +  i.toString()).value;
        
        recInfo  = document.getElementById('id_info_' +  i.toString()).value;
        data.setAttribute('id', recID);
        data.setAttribute('answer', recAnswer);
        data.setAttribute('elapsedtime', recElapsedtime);
        data.setAttribute('score', (recPElapsedtime / recElapsedtime));
        data.setAttribute('info', recInfo);
        record.appendChild(data);
        //alert('Registro: ' + recID + '\n' + recAnswer + '\n' + recElapsedtime);
        //alert('Atualizado em:' + i.toString());
      }//end-if (opt == '1'){
        
    }//end-for (var i = 0; i < mIndex; i++){
    doc.appendChild(record);
    if (flag == 1){
        var xmlHttp = new XMLHttpRequest();
        //          xmlHttp.open("POST", "http://192.168.1.21/toupdatesubmmity.php", true); // true for asynchronous
      // alert("fim");
      xmlHttp.onreadystatechange = function() {
          if (xhr.readyState == 4) {
            console.log(readBody(xmlHttp));
          }
        }
        //xmlHttp.open("POST", "toupdatesubmmity.php", true); // true for asynchronous
        xmlHttp.open("POST", "updatedSubmission.php", true); // true for asynchronous
        
        xmlHttp.setRequestHeader('Content-type', 'application/xml; charset=utf-8');
        var myXML = new XMLSerializer();
        var msg = myXML.serializeToString(doc);
        alert(msg);
        var ret = xmlHttp.send(msg);
        alert('Atualizado com sucesso');
        alert(ret);
        //window.history.back();
    }else{
      alert('Não existe registros para serem atualizados!');
    }
    
    

    
}