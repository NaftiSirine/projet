<?php
namespace App\Controller ;
use Symfony\Component\HttpFoundation\Response;
class TodayDateController {
 public function date(){
   $date = date("d/m/Y");
return new Response(
    '<html><body> Today is :'.$date.'</body></html>');
}

}
?>