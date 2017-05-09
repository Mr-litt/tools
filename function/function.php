<?php
/**
 * Created by IntelliJ IDEA.
 * User: lihaitao
 * Date: 17-5-9
 * Time: 上午10:36
 */


/**
 * 获取输入参数 支持过滤和默认值
 * @param string $name 变量的名称
 * @param mixed $default 不存在的时候默认值
 * @param mixed $filter 参数过滤方法
 * @return mixed
 */
function I($name, $default='', $filter=null) {

    if($name) { // 取值操作
        // is_array($name) && array_walk_recursive($name,'filter_exp');
        $filters    =   isset($filter)?$filter:'htmlspecialchars';
        if($filters) {
            $filters    =   explode(',',$filters);
            foreach($filters as $filter){
                if(function_exists($filter)) {
                    $name   =   is_array($name)?array_map_recursive($filter,$name):$filter($name); // 参数过滤
                }else{
                    $name   =   filter_var($name,is_int($filter)?$filter:filter_id($filter));
                    if(false === $name) {
                        return   isset($default)?$default:'';
                    }
                }
            }
        }
    }else{ // 变量默认值
        $name       =    isset($default)?$default:'';
    }
    return $name;
}

function array_map_recursive($filter, $data) {
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val)
            ? array_map_recursive($filter, $val)
            : call_user_func($filter, $val);
    }
    return $result;
}




/**
 * 密码加密方式
 * @param string $pwd 密码
 * @param string $salt 附加字符
 * @return string
 */
function md5Pwd( $pwd, $salt ) {
    return md5(md5($pwd).$salt);
}



/**
 * 对象转数组
 * @param $obj
 * @return array
 */
function objectToArray($obj) {
    $array = [];
    if(is_object($obj)) {
        $array = (array)$obj;
    } if(is_array($obj)) {
        foreach($obj as $key=>$value) {
            $array[$key] = objectToArray($value);
        }
    }
    return $array;
}


/**
 * 生成指定字段数组
 * @param array	$list	原数据集
 * @param string $field	需生成数组的字段
 * @param int $uniq		唯一（默认）
 */
function make_array( $list, $field, $uniq=1 ) {
    $aim_array = array();
    if ( !empty($list) ) {
        $list = (array) $list;
        foreach ($list as $key => $value) {
            $value = (array) $value;
            $aim_array[] = $value[$field];
        }
        if ($uniq) {
            $aim_array = array_unique($aim_array);
        }
    }
    //
    return $aim_array;
}

/**
 * 根据某字段设置数组的键
 * @param array $list
 * @param String $field
 * @return array
 */
function make_array_key($list,$field){
    $aim_array = array();
    //
    if ( !empty($list) ) {
        $list = (array) $list;

        foreach ($list as $key => $value) {

            $value = (array) $value;
            $aim_array[$value[$field]] = $value;
        }
    }
    //
    return $aim_array;
}