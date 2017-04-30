<?php


//针对UM，UE等编辑器，有选择性的过滤  --  只将比较危险的标签转化为实体
function  removeXss($data){
    require_once   'HtmlPurifier/HTMLPurifier.auto.php' ;
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    //设置不转义的标签
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    //执行过滤
   return   $_clean_xss_obj->purify($data);
}


//从配置文件中读取图片显示路径
function  showImg($url){
    $ic = C('IMG_CONFIG');      //  Category  函数便是配置文件
    echo    "<img src='{$ic['viewPath']}$url' style='width: 80px; height: 100px'>"  ;
}


/**
 * 使用一个表中的数据制作下拉框
 *
 */
function buildSelect($tableName, $selectName, $valueFieldName, $textFieldName, $selectedValue = '')
{
    $model = D($tableName);
    $data = $model->field("$valueFieldName,$textFieldName")->select();
    $select = "<select name='$selectName'><option value=''>请选择</option>";
    foreach ($data as $k => $v)
    {
        $value = $v[$valueFieldName];
        $text = $v[$textFieldName];
        if($selectedValue && $selectedValue==$value)
            $selected = 'selected="selected"';
        else
            $selected = '';
        $select .= '<option '.$selected.' value="'.$value.'">'.$text.'</option>';
    }
    $select .= '</select>';
    echo $select;
}