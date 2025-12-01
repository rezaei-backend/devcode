<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use Illuminate\Http\Request;

class DocCountroller extends Controller
{
    public function index()
    {
        function textdoc($doc){

                $example_code=$doc->example_code;
                $example_output=$doc->output;
                $outputs=explode('@output',$example_output);
                $codes=explode("@code",$example_code);
                $codes=array_values(array_filter($codes));
                $outputs=array_values(array_filter($outputs));
                $contents=explode("@run",$doc->content);

                $contents=array_values(array_filter($contents));
                $i=0;
                $text="";


                foreach ($contents as $content){

                    $text.= $content."<br>";
                    if (!empty($codes[$i]) AND $codes[$i]!="@code") {

                        $code=explode('@endcode',$codes[$i]);
                        $output=explode("@endoutput",$outputs[$i]);
                        $text .=  $code[0] ."<br>";
                        $text .= $output[0] . "<br>";
                        $text .="_______________________________________________________________________________________________________<br>";

                    }
                    $i++;
                }

                return $text;

            }

        $doc=Doc::find(3);

$text= textdoc($doc);
echo $text;
    }

}
