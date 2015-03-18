<center>
<br><br>
<span style="font-size:22px;"> Mumble viewer </span>
<br><br>
</center>
<div class="well" style="margin: 0 auto; width:80%">
<?php

  if (isset($Server)) {

    function displayChannels($tree, $indent)
    {

      for ($i=0; $i<$indent; $i++)
        echo '<span class="indent-channel"> </span>';
      echo ($indent == 0) ? '<p>' : '';
        echo '<span id="'. $tree->c->id .'">'. $tree->c->name .'</span><br>';
        foreach($tree->users as $user) {
          for ($i=0; $i<$indent; $i++)
            echo '<span class="indent-channel"> </span>';
          echo '<span class="indent-user"> </span>';
          echo '<span id="'. $user->userid .'" class="user">';
          if ($user->mute)
            echo ' <i style="color:#027A9D;" class="fa fa-microphone-slash"></i> ';
          if ($user->selfMute)
            echo ' <i style="color:#C73C34;" class="fa fa-microphone-slash"></i> ';
          if ($user->deaf)
            echo ' <i style="color:#027A9D;" class="fa fa-volume-off"></i> ';
          if ($user->selfDeaf)
            echo ' <i style="color:#C73C34;" class="fa fa-volume-off"></i> ';
          echo $user->name .'</span>';
        }
        echo (!empty($tree->users)) ? '<br>' : '';
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
