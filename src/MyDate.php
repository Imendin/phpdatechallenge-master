<?php

  class MyDate {   
      
    public static function diff($start, $end) {
      $s = new DateTime($start);
      $e = new DateTime($end);
      $ys = $s->format('Y');
      $ms = $s->format('m');  
      $ds = $s->format('d');
      $ye = $e->format('Y');
      $me = $e->format('m');
      $de = $e->format('d');
      $yd = 0;
      $md = 0;
      $dd = 0;
      $alld = 0; 
      $invert = false;
      
      if($ye >= $ys && $invert == false){
        $yd = $ye - $ys;
      } else {
        $invert = true;
        $yd = $ys - $ye;
      }
      if($me >= $ms && $invert == false){
        $md = $me - $ms;
      } else {
        if($ye > $ys){
          $yd--;
          $md = 12 - $ms + $me;
        } else {
          $invert = true;
          $md = $ms - $me;
        }
      }
      if($de >= $ds && $invert == false){
        $dd = $de - $ds;
      } else {
        if($ye > $ys){
            $md --;
            if(strpos(($ye / 4), '.') !== false){ 
              $dd = MyDate::daybig(false, $me, $ds, $de);  
            } else {
              $dd = MyDate::daybig(true, $me, $ds, $de);   
            }
        } else {
         if($me > $ms){
            $md --;
            if(strpos(($ye / 4), '.') !== false){ 
              $dd = MyDate::daybig(false, $me, $ds, $de);  
            } else {
              $dd = MyDate::daybig(true, $me, $ds, $de);   
            }
          } else {
            $invert = true;
            $dd = $ds - $de;
          }
        }
      }
      if($yd != 0){
        for($i = 0; $i <= $yd; $i++){
          if($i == 0){
            if(strpos(($ys / 4), '.') !== false){
              $alld = MyDate::firstcount(false, $ms, $ds, $dd, 0);  
            } else {
              $alld = MyDate::firstcount(true, $ms, $ds, $dd, 0);   
            }
          } else if($i == $yd) {
            if(strpos(($ye / 4) , '.') !== false){
              for($g = 0; $g < $me; $g++){
                $alld = MyDate::subcount(1, false, $g, $alld);
              }
            } else {
              for($g = 0; $g < $me; $g++){
                $alld = MyDate::subcount(1, true, $g, $alld);
              }  
            }
            $alld += $de;
          } else {
            if(strpos((($ys + $i) / 4), '.') !== false){
              $alld += 365;  
            } else {
              $alld += 366;   
            }
          }
        }
      } else {
        if($md != 0){
            if(strpos(($ye / 4), '.') !== false){
              for($g = 0; $g < $me; $g++){
                $alld = MyDate::subcount(1, false, $g, $alld);
              }
            } else {
              for($g = 0; $g < $me; $g++){
                $alld = MyDate::subcount(1, true, $g, $alld);
              }  
            }
            $alld += $de;
        } else {
          $alld = $dd;
        }
      }
      return (object)array(
        'years' => $yd,
        'months' => $md,
        'days' => $dd,
        'total_days' => $alld,
        'invert' => $invert
      );
    }
    static function daybig ($leap, $me, $ds, $de){
        if($me == 1 || $me == 3 || $me == 5 || $me == 7 || $me == 8 || $me == 10 || $me == 12){
          $dds = 31 - $ds + $de;
        } else if($me == 2){
          if($leap == true){
            $dds = 29 - $ds + $de;
          } else {
            $dds = 28 - $ds + $de;
          }
        } else {
          $dds = 30 - $ds + $de;
        }
        return $dds;
      }         
     static function firstcount ($leap, $ms, $ds, $dd, $alld){
        $allds = $alld;
            if($ms == 1 || $ms == 3 || $ms == 5 || $ms == 7 || $ms == 8 || $ms == 10 || $ms == 12){
              if($ds < 31){
                for($j = 0; $j < $ms; $j++){
                  $allds = MyDate::subcount(1, $leap, $j, $allds);
                }
                if($leap == true){
                  $allds = 366 - $allds - $ds; 
                } else {
                  $allds = 365 - $allds - $ds; 
                }
              } else  {
                for($j = 0; $j <= $ms; $j++){
                  $allds = MyDate::subcount(1, $leap, $j, $allds);
                }
                if($leap == true){
                  $allds = 366 - $allds; 
                } else {
                  $allds = 365 - $allds; 
                }
              }
            } else if($ms == 2){
              if($leap == false){
                if($ds < 28){
                  for($j = 0; $j < $ms; $j++){
                    $allds = MyDate::subcount(1, $leap, $j, $allds);
                  }
                  $allds = 365 - $allds - $ds; 
                } else {
                  for($j = 0; $j <= $ms; $j++){
                    $allds = MyDate::subcount(1, $leap, $j, $allds);
                  }
                  $allds = 365 - $allds;
                }
              } else {
                if($ds < 29){
                  for($j = 0; $j < $ms; $j++){
                    $allds = MyDate::subcount(1, $leap, $j, $allds);
                  }
                  $allds = 366 - $allds - $ds;
                } else {
                  for($j = 0; $j <= $ms; $j++){
                    $allds = MyDate::subcount(1, $leap, $j, $allds);
                  }
                  $allds = 366 - $allds;
                }
              }
            } else {
              if($ds < 30){
                for($j = 0; $j < $ms; $j++){
                  $allds = MyDate::subcount(1, $leap, $j, $allds);
                }
                if($leap == true){
                  $allds = 366 - $allds - $ds; 
                } else {
                  $allds = 365 - $allds - $ds; 
                }
              } else {
                for($j = 0; $j <= $ms; $j++){
                  $allds = MyDate::subcount(1, $leap, $j, $allds);
                }
                if($leap == true){
                  $allds = 366 - $allds; 
                } else {
                  $allds = 365 - $allds; 
                }
              }
            }
            return $allds; 
      }      
     static function subcount ($m, $leap, $g, $alld){
        $allds = $alld;
        if(($m + $g) == 1 || ($m + $g) == 3 || ($m + $g) == 5 || ($m + $g) == 7 || ($m + $g) == 8 || ($m + $g) == 10 || ($m + $g) == 12){
           $allds += 31; 
        } else if(($m + $g) == 2){
          if($leap == true){
            $allds += 29;
          } else {
            $allds += 28;
          }
        } else {
          $allds += 30;
        }
        return $allds;
      }     
  }
