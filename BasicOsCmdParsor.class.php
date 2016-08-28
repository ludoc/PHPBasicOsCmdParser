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

  public function uptime(){
    exec('uptime', $stdout);
    $uptimeLine = preg_split('#\s+#', $stdout[0]);
    $result = array('uptime' => rtrim($uptimeLine[3], ','));
    return $result;
  }

  public function ps(){
    exec('ps aux', $stdout);
    $result = array();
    foreach($stdout as $key => $value){
      if($key != 0){
        $psLine = preg_split('#\s+#', $value, 11);
        $result[$psLine[1]] = array('user' => $psLine[0],
                          'pid' => $psLine[1],
                          'cpu_percent' => $psLine[2],
                          'mem_percent' => $psLine[3],
                          'vsz' => $psLine[4],
                          'rss' => $psLine[5],
                          'tty' => $psLine[6],
                          'stat' => $psLine[7],
                          'start' => $psLine[8],
                          'time' => $psLine[9],
                          'command' => $psLine[10]);
      }
    }
    return $result;
  }
}
?>
