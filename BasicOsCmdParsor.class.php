<?php

class BasicOsCmdParsor{

  public function df(){
    $cmd = exec('df', $stdout);
    $result = array();
    foreach($stdout as $key => $value){
      if($key != 0){
        $dfLine = preg_split('#\s+#', $value);
        $result[$dfLine[0]] = array('fs' => $dfLine[0],
        'size' => $dfLine[1],
        'used' => $dfLine[2],
        'used_percent' => $dfLine[4],
        'free' => $dfLine[3],
        'mount_point' => $dfLine[5]
      );
    }
  }
  return $result;
}


}
?>
