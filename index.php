<!DOCTYPE html>

<html dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>Harrez explorer</title>
    </head>
    <body>
        <form action="#" method="post">
            <label>הקלד כתובת:</label> <input type="url" required="" name="haarez" id="haarez"/>
            <input type="submit"/>
        </form>
        <?php
        if(isset($_POST)&&isset($_POST["haarez"]))
        {
            $url=$_POST["haarez"];
 //    print $url;
            
     if(!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))
     {
         die("wrong url");
         
     }
     $pattern= "/^(http(s)?:\/\/)?(www.)?haaretz.co.il\/[\w-\/]+(\.premium-)?(1.\d+)$/";
     if(!preg_match($pattern, $url))
     {
         die("no haarez valid url");
     }
     $arr=array();
     preg_match($pattern, $url,$arr);
      $idHaarez=$arr[5];
     $xml=simplexml_load_file("http://www.haaretz.co.il/api/getArticleFeed?dataType=xml&id=".$idHaarez);
     print "<h1>".$xml->title."</h1>"; //Title
      print "<h2>".$xml->subtitle."</h2>"; //subtitle
     print $xml->text; //Article
	 //Images downloaded separately
     print "<h1>images</h1>";
     foreach ($xml->image->children() as $child)
     {
         print "<img  style='width:100%;' src=\"".$child->url."\" title=\"".$child->title."\"/> <br> <label>".$child->description." - ".$child->credit."<br>";
     }
        }
        else 
        {
            //Do nothing
        }
        ?>
    </body>
</html>
