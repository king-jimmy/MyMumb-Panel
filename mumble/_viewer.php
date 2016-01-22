<br>
<div class="well" style="margin: 0 auto; width:80%">
<?php

  if (isset($Server)) {

    function displayChannels($tree, $indent)
    {

      for ($i=0; $i<$indent; $i++)
        echo '<span class="indent-channel"> </span>';
      echo ($indent == 0) ? '<p>' : '';
        echo '<span id="'. $tree->c->id .'">'. $tree->c->name .'</span>';
        echo (count($tree->users)) ? '' : '<br>';
        foreach($tree->users as $user) {
          echo '<span class="user-in"> </span>';
          for ($i=0; $i<$indent; $i++)
            echo '<span class="indent-channel"> </span>';
          echo '<span class="indent-user"> </span>';
          echo '<span id="'. $user->userid .'" class="user">';
          $color = '';
          if ($user->mute) {
            $color = '027A9D';
            echo ' <i style="color:#'. $color .';" class="fa fa-microphone-slash"></i> ';
          }
          if ($user->selfMute) {
            $color = 'C73C34';
            echo ' <i style="color:#'. $color .';" class="fa fa-microphone-slash"></i> ';
          }
          if ($user->deaf) {
            $color = '027A9D';
            echo ' <i style="color:#'. $color .';" class="fa fa-volume-off"></i> ';
          }
          if ($user->selfDeaf) {
            $color = 'C73C34';
            echo ' <i style="color:#'. $color .';" class="fa fa-volume-off"></i> ';
          }

          echo '<span class="fa fa-user"';
          echo ($color !== '') ? 'style="color:#'. $color .'";' : '';
          echo '></span>';
          echo $user->name .'</span>';
        }
        echo (!empty($tree->users)) ? '<br>' : '';
        usort($tree->children, function($a, $b) {
          return ($a->c->name < $b->c->name) ? -1 : 1;
        });
        foreach($tree->children as $channel)
          displayChannels($channel, $indent+1);
      echo ($indent == 0) ? '</p>' : '';
    }

    // Display server name
    echo '<center><p>'.$Server->getConf('registername').'</p></center>';

    // Display channels & users
    displayChannels($Server->getTree(), 0);
  }

echo '</div>';
