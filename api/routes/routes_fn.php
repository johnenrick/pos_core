<?php
function api_resource($apiReource){
  $apiResources = (is_array($apiReource))? $apiReource : [$apiReource];
  foreach($apiResources as $apiResourceValue){
    $pascalCase = preg_replace_callback("/(?:^|_)([a-z])/", function($matches) {
        return strtoupper($matches[1]);
    }, $apiResourceValue) . 'Controller';
    Route::get($apiResourceValue."/",$pascalCase."@index");
    Route::get($apiResourceValue."/test",$pascalCase."@test");
    Route::post($apiResourceValue."/create",$pascalCase."@create");
    Route::post($apiResourceValue."/retrieve",$pascalCase."@retrieve");
    Route::post($apiResourceValue."/update",$pascalCase."@update");
    Route::post($apiResourceValue."/delete",$pascalCase."@delete");
  }
}
function custom_api($customAPIResource, $method = 'post'){
  // print_r($customAPI);
  for($x = 0; $x < count($customAPIResource); $x++){
    $customAPI = $customAPIResource[$x];
    $splitAPI = explode('/', $customAPIResource[$x]);
    $pascalCase = preg_replace_callback("/(?:^|_)([a-z])/", function($matches) {
        return strtoupper($matches[1]);
    }, $splitAPI[0]) . 'Controller';
    if($method == 'post'){
      Route::post($customAPI, $pascalCase."@".$splitAPI[1]);
    }
  }

}
?>