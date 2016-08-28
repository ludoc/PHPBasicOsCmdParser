<?php

class BasicOsCmdParsor{

  public function df(){
    exec('df', $stdout);
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

  public function loadAverage(){
    exec('uptime', $stdout);
    $uptimeLine = preg_split('#\s+#', $stdout[0]);
    $result = array('lavg1m' => rtrim($uptimeLine[8], ','),
                    'lavg5m' => rtrim($uptimeLine[9], ','),
                    'lavg15m' => rtrim($uptimeLine[10], ','));
    return $result;
  }
}
?>
