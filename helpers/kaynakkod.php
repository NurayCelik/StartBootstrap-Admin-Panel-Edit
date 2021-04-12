<?php

String token = await Candidate().getToken();
final response = await http.get(url, headers: {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer $token',
});
print('Token : ${token}');
print(response);

/////////////////////////////////////////////

var jsonresponse = Map();
  Future login() async{
  try{
      response = await http.post(
        baseLog,    
        body: {
          "username": username.text,
          "password": password.text
        },            
      );    
      //json decode
      this.jsonresponse = json.decode(this.response);    
      var token = this.response.headers['date'];  //an attempt to access the header
      //print('token  ' + token);          
    }
    catch(ex){
      print('Error occured' + ex);
    }
  }
  var response = await http.post(
    baseLog,

    body: {
      "username": username.text,
      "password": password.text
    },
  );
var token = response.headers['date'];


///////////////////////////

$assocData = array('0' => array('0' => 123, '1'=>123));
$arrayData = array_map('array_values', array_values($assocData));
echo json_encode($arrayData);


////////////////////////////
/////
//php ile jwt oluşturma///
/////////////////////////

// Create token header as a JSON string
$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

// Create token payload as a JSON string
$payload = json_encode(['user_id' => 123]);

// Encode Header to Base64Url String
$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

// Encode Payload to Base64Url String
$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

// Create Signature Hash
$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);

// Encode Signature to Base64Url String
$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

// Create JWT
$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

echo $jwt;

///////////////////////////////
List<MyModel> myModels;
var response = await http.get("myUrl");

myModels=(json.decode(response.body) as List).map((i) =>
              MyModel.fromJson(i)).toList();

Dogru Yazım

List<MyModel> myModels;
var response = await http.get("myUrl");

myModels=(json.decode(response.body) as List).map((i) =>
              MyModel.fromJson(i)).toList();

//////////////////////  
List<String> stringList = (jsonDecode(input) as List<dynamic>).cast<String>();
ya da 
var rellyAStringList = jsonDecode(input);
for (String string in reallyAStringList) { ... }
////////////////////

?>