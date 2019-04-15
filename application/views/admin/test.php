<?php
echo form_open_multipart('gallery');
echo form_upload('userfile');
echo form_submit('upload', 'Upload');
echo form_close();
?>