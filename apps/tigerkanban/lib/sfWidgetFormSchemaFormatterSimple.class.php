<?php

class sfWidgetFormSchemaFormatterSimple extends sfWidgetFormSchemaFormatter
{
    protected
        $rowFormat = '%error%%label%%field%',
        $helpFormat = '<div class="formhelp">%help%</div>',
        $errorRowFormat = '<div class="formerror">%errors%</div>',
        $errorListFormatInARow = '%errors%',
        $errorRowFormatInARow = '<div class="formError">&darr;&nbsp;%error%&nbsp;&darr;</div>',
        $namedErrorRowFormatInARow = '%name%: %error%<br />',
        $decoratorFormat = '<div id="formContainer">%content%</div>';
}


//text ui-widget-content ui-corner-all