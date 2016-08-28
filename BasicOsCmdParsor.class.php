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

  public function passwdInfo(){
    exec('cat /etc/passwd', $stdout);
    $result = array();
    foreach($stdout as $user){
      $parsedUser = explode(':', $user);
      $result[$parsedUser[0]] = array('username' => $parsedUser[0],
                        'password' => $parsedUser[1],
                        'uid' => $parsedUser[2],
                        'gid' => $parsedUser[3],
                        'user_info' => $parsedUser[4],
                        'home' => $parsedUser[5],
                        'shell' => $parsedUser[6]);
    }
    return $result;
  }

  public function shadowInfo(){
    exec('cat /etc/shadow', $stdout);
    $result = array();
    foreach($stdout as $user){
      $parsedUser = explode(':', $user);
      $result[$parsedUser[0]] = array('username' => $parsedUser[0],
                        'password' => $parsedUser[1],
                        'lastchanged' => $parsedUser[2],
                        'min_day' => $parsedUser[3],
                        'password_expire' => $parsedUser[4],
                        'warn' => $parsedUser[5],
                        'inactive' => $parsedUser[6],
                        'account_expire' => $parsedUser[7]);
    }
    return $result;
  }

  public function netstat(){
    exec('netstat -taupen', $stdout);
    $result = array();
    foreach($stdout as $key => $netstat){
      if($key != 0){
        $parsedNetstat = preg_split('#\s+#', $netstat);
        $result[] = array('proto' => $parsedNetstat[0],
                          'recv-q' => $parsedNetstat[1],
                          'send-q' => $parsedNetstat[2],
                          'local_address' => $parsedNetstat[3],
                          'remote_address' => $parsedNetstat[4],
                          'state' => ($parsedNetstat[0] == 'tcp' || $parsedNetstat == 'tcp6') ? $parsedNetstat[5] : '',
                          'user' => ($parsedNetstat[0] == 'tcp' || $parsedNetstat == 'tcp6') ? $parsedNetstat[6] : $parsedNetstat[5],
                          'inode' => ($parsedNetstat[0] == 'tcp' || $parsedNetstat == 'tcp6') ? $parsedNetstat[7] : $parsedNetstat[6],
                          'pid' => ($parsedNetstat[0] == 'tcp' || $parsedNetstat == 'tcp6') ? $parsedNetstat[8] : $parsedNetstat[7]);
      }
    }
    return $result;
  }

  public function nameserver(){
    exec('cat /etc/resolv.conf | grep nameserver', $stdout);
    $result = array();
    foreach($stdout as $ns){
      $parsedNs = explode(' ', $ns);
      $result[] = $parsedNs[1];
    }
    return $result;
  }
}
?>
