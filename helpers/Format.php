<?php
class Format{

   public function controlDigit($data){ 
       //id kontrol için ilk rakamı 0 haricinde rakam ve 15 haneli sayıları eşleştirme
        return preg_match('/^[1-9][0-9]{0,15}$/',$data);
    }
    public function MailKontrolEt($mail)
    {
       $email_exp = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/';
         
        return preg_match($email_exp,$mail);
    }
    public function emailKontrolEt($email)
{
 
   $islem = filter_var($email, FILTER_VALIDATE_EMAIL);
   return $islem;
 }

    
  public function validation($data){
  $data1 = trim($data);
  $data2 = stripcslashes($data1);
  $data3 = htmlspecialchars($data2);
  return $data3; // here i return this $data variable so we can use this.
 }
public function textShorten($text, $limit = 800){
	$text1 = $text. "";
	$text2 = substr($text1, 0, $limit);
	return $text2; 
}	
public function textShortenDat($text, $limit = 800){
	$text1 = $text. "";
	$text2 = substr($text1, 0, $limit);
	$text3 = $text2."...";
	return $text3; 
}
public function uzunMetin($string){
// strip tags to avoid breaking any html
$string = strip_tags($string);
if (strlen($string) > 500) {

    // truncate string
    $stringCut = substr($string, 0, 500);
    $endPoint = strrpos($stringCut, ' ');

    //if the string doesn't contain any space then it will cut without word basis.
    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    $string .= '... <a href="/this/story">Read More</a>';
}
return $string;
}


  public function sqlonleme($data)
    {
       $bad = array("/content-type/","/bcc\:/","/\:/","/cc\:/","/href/","/select/","/\*from/","/FROM/","/SET/","/set/","/update/","/UPDATE/","/updateset/","/UPDATESET/","/UPDATE SET/","/DELETE/","/delete/","/\*/","/s3/","/S3/","/%7C/","/%2B/");
      $islem = preg_replace($bad,'',$data);
      return $islem;
      } 
       
public function sqlonlemeforSerch($data)
    {
       $bad = array("content-type","bcc:","to:","cc:","href","* from","* FROM","*from","*FROM","select","SELECT","SET","set","update","UPDATE","updateset","UPDATESET","UPDATE SET","DELETE","delete","*","SELECT*FROM","s3","S3","%7C","%2B");
      $islem = str_replace($bad,"",$data);
      
      return $islem;
    }
    public function sqlonlemeforCatering($data)
    {
       $bad = array("content-type","href","* from","* FROM","*from","*FROM","UPDATE SET","SELECT*FROM","SELECT * FROM","SELECT *FROM","SELECT* FROM","select*from","select* from","select *from","select * from","s3","S3","%7C","%2B");
      if($islem = str_replace($bad,"",$data)){
       //header("Location:404.php");
       return $islem;
    }
  }


public function telefonKontrolEt($veri)
{
  $islem = preg_match('/^[0-9\-\s\(\)\.]*$/',$veri);
 if($islem)
  return $islem;
}
public function textKontrolEt($veri)
{
    //$ifade='/^[a-zA-Z]+$/'; //Bu ifade sadece harf kontrol eder
    
    $ifade = '/[a-zA-ZçığöşüÇĞİÖŞÜ ]+$/i'; //Türkçe Uyumlu
    $islem= preg_match($ifade, $veri);
    return $islem;
    
}
public function textKontrolEtOzel($veri)
{
    $bad = array("/content-type/","/bcc\:/","/\:/","/cc\:/","/href/","/select/","/\*from/","/FROM/","/SET/","/set/","/update/","/UPDATE/","/updateset/","/UPDATESET/","/UPDATE SET/","/DELETE/","/delete/","/\*/","/s3/","/S3/","/%7C/","/%2B/","/'/","/=/","/%/","/\?/","/:/");
      $islem = preg_replace($bad,'',$veri);
     return $islem;
  }

public function textKontrolCatering($veri)
{
 $islem =  preg_replace("/[^a-zA-Z0-9çığöşüÇĞİÖŞÜ .,]+/", "?", html_entity_decode($veri, ENT_QUOTES)); //harf, rakam boşluk nokta ve virgül haricindeki işaretleri ? işaretine dönüştürür.

 return $islem;

}
public function adminNameKontrol($veri)
{
    $aValid = array('-', '_');
    $islem  = ctype_alnum(str_replace($aValid, '', $veri));//alfanümerik

   return $islem;

}
public function sifreKontrolEt($veri)
{
  
    $ifade = '/[A-Za-z0-9-_$]{3,}+$/';
    $islem = preg_match($ifade, $veri);
      return $islem;
    
}



 public function formatDate($date){

 return date('m.d.Y - H:i:s', strtotime($date));
 }
 public function formatDateTurk($date){

 return date('d.m.Y  H:i:s', strtotime($date));
 }

 public function formatDateOnly($date){
 return date('d-m-Y', strtotime($date));
 }

 public function formatGetYearOnly($date){
 return date('Y', strtotime($date));
 }


public function seo($s) {
	$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',' ',',','?');
	$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','');
	$s = str_replace($tr,$eng,$s);
	$s = strtolower($s);
	$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
	$s = preg_replace('/\s+/', '-', $s);
	$s = preg_replace('|-+|', '-', $s);
	$s = preg_replace('/#/', '', $s);
	$s = str_replace('.', '', $s);
	$s = trim($s, '-');
	return $s;
}

public function tcevir($tarih){
	$tr = explode("-",$tarih); 
	$tarih1 = $tr[2]."-".$tr[1]."-".$tr[0]; 
	return $tarih1;
}

public function cumleAdediBelirleParagrafta($data=[],$className,$sayi){

$sentences = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $data); //metni noktalama işaretlerine göre bölüyor. 
$cumleAdedi = count($sentences);
$s= 0;
for($i=0; $i<$cumleAdedi;$i++){

  if($s==0){
    echo'<p class="'.$className.'">';//varsa class ismi yazıldı sadece ilk pragrafa
    }
    

if($i%$sayi==0)//3cümle her paragrag
{
echo'</p><p>';
}

echo $sentences[$i]." ";
$s++;
}
}
public function cumleAdediBelirleFotoyaGore($data=[],$className,$foto,$sayi){

$sentences = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $data); //metni noktalama işaretlerine göre bölüyor. 
$cumleAdedi = count($sentences);
$s = 0;
for($i=0; $i<$cumleAdedi;$i++){
 $s++;
  if($i%$sayi==0)//3cümle her paragrag
{ 
  
  echo'<p>';
}

if($s==2){
    echo'<p class="'.$className.'"><img src="'.$foto.'" alt=""/></p><p>';

    }


echo $sentences[$i]." ";
 
}
echo'</p>';
}
function format_punc($string){
    $punctuation = ';:?!,';//noktalama işaretleri noktayı eklemedim, onu eklersek başka 3 nokta çalışmaz, noktalama işareti için cumleAdediBelirleParagrafta() fonksiyonunda ekleniyor.Problem değil..

    $string = preg_replace('/(['.$punctuation.'])[\s]*/', '\1 ', $string); //Noktalama işaretlerinden sonra boşluk
    $string = preg_replace('/\.{3,}/','… ',$string); //3 nokta sonuna boşluk
    $string = preg_replace('/\.{2}/','. ',$string);//iki nokta ise bir nokta ve boşluk olsun
    $string = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string);//virgülden sonra bir sayı parçası değilse boşluk 
    if($string[strlen($string)-1]==','){ // cümle sonu virgül ise nokta yapar.
    $string = substr($string, 0, -1).'.';
    
    }
    return $string;
    
}
public function yerDegistir($sablon=[],$new=[],$text){
  
   $data   = preg_replace($sablon,$new,$text);
  return $data;

	}
public function fotoAdDegistir($sablon=[],$new=[],$text){
  
   $data   = str_replace($sablon,$new,$text);
  return $data;

  }
  public function isaretDegistir($sablon=[],$new=[],$text){
  
   $data   = str_replace($sablon,$new,$text);
  return $data;

  }
	public function rakamAraEnfazla($text){
  
   $ara = '/^\d{1,3}(,\d{3})*(\.\d+)?$/'; //rakam, nokta ve  virgül ile eşleştirir.
   $data   = preg_match($ara,$text);
   return $data;
}
public function rakamAraEnaz($text){
  
  $ara = '/^[0-9]{1,}([,.][0-9]{1,})?$/'; //en az 1 rakam, nokta veya virgül sonra en az 1ile eşleştirir.
  $data   = preg_match($ara,$text);
  return $data;
} 
public function rakamAra($text){
    
  $ara = '/^[0-9]{1,}([0-9,.]{1,})?$/'; //en az 1 rakam, nokta veya virgül sonra en az 1ile eşleştirir.
  $data   = preg_match($ara,$text);
  return $data;
} 
public function findNumCharComma($text){
  
  $ara = '/^[a-zA-Z0-9]+[a-zA-Z0-9 ,:]+$/'; //rakam, harf, noşluk, virgül,ikinokta ustuste ile eşleştirir.
  $data   = preg_match($ara,$text);
  return $data;
}
  public function dateTimeAra($text){
  //year : ay : gun : saat : dakika : saniye
  $data = preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $text);
  return $data;
 
}

}
?>