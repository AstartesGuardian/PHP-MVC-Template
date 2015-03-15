<?php
session_start();

require 'Framework/Channel.php';

$channel = new Channel();
$channel->channelRequest();