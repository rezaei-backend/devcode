<?php

namespace App\Traits;

trait DocActive
{
    public function textdoc($doc){

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

             $text .=<<<HTML
<div class='code-block' id=example$i>
                    <div class='code-header'>
                        <span class='code-lang'>code</span>
                        <button class='btn-copy' data-target=example$i>کپی</button>
                    </div>
                    <pre><code>
<span class='token.comment'>
   $code[0]
</span>

</code></pre></div>
HTML;

                $text .= "<div class='output-block' >
                    <div class='output-header'>
                        <span class='output-lang'>output</span>

                    </div>
                    <pre><code>
<span class='token.comment'>
   $output[0]
</span>

</code></pre></div>";

?>
<?php
            }
            $i++;
        }

        return $text;

    }
}
