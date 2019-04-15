<?php
class Gallery_model extends CI_Model {
  var $original_path;
  var $resized_path;
  var $thumbs_path;
    function __construct()
    {
        parent::__construct();  
    }

    function do_upload($file, $directory, $user_id="")
    {
        $this->original_path = realpath(APPPATH . $directory);
        // $this->resized_path = realpath(APPPATH . $directory . '/resized');
        $this->thumbs_path = realpath(APPPATH . $directory . '/thumbnail');
        $config = array(
                        'allowed_types' => 'jpg|jpeg|gif|png',
                        'upload_path' => $this->original_path,
                        'file_name' => $user_id,
                        'overwrite' => TRUE
                        );

        $this->load->library('upload', $config);

        if ($this->upload->validate_upload($file))
        {
            /*print $this->original_path . ' : 1<hr>';
            // print $this->resized_path . ' : 2<hr>';
            print $this->thumbs_path . ' : 3 <hr>';
            print $file . ' : 4 <hr>';*/

            $this->load->library('image_lib');              
            $this->upload->do_upload($file);
            $image_data = $this->upload->data();
            $file_name = $image_data["file_name"];
            
            $config = array(
                'image_library' => 'gd2',
                'source_image'      => $image_data['full_path'], //path to the uploaded image
                'maintain_ratio'    => true,
                'height'            => 350,
                'width'            => 350
            );
            $this->image_lib->initialize($config);
            if ( ! $this->image_lib->resize())
            {
                print '<br>Error @ resize: ' . $this->image_lib->display_errors() . 
                        '<br>Path: ' . $image_data['full_path'] . 
                        '<br>Path 2: ' . $path;
            }
            $config = array(
                'image_library' => 'gd2',
                'source_image'      => $image_data['full_path'], //path to the uploaded image
                'new_image'      => $this->thumbs_path, //path to the uploaded image
                'maintain_ratio'    => true,
                'width'             => 128,
                'height'            => 128
            );
            $this->image_lib->initialize($config);
            if ( ! $this->image_lib->resize())
            {
                print '<br>Error @ thumnbnail: ' . $this->image_lib->display_errors() . 
                        '<br>Path: ' . $image_data['full_path'] . 
                        '<br>Path 2: ' . $path;
            }
            return $file_name;
        }
        else
           return false;     
     }  
    function get_images()
    {
            $files = scandir($this->gallery_path);
            $files = array_diff($files, array('.', '..', 'thumbs'));
            $images = array();
            foreach ($files as $file)
            {
                    $images []= array (
                            'url' => $this->gallery_path_url . $file,
                            'thumb_url' => $this->gallery_path_url . 'thumbs/' . $file
                    );
            }
            return $images;
    }
    function thumbnail($img, $path)
    {       
        // copy($img, $path . 'thumbnail');
        $new_img_path = $path . 'thumbnail/';
        $config = array(
            'source_image' => $path . $img,
            'new_image' => $new_img_path,
            'maintain_ratio' => TRUE,
            'overwrite' => TRUE,
            'height' => 150
        );
        print_r ($config);
        try
        {
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
        }
        catch (Exception $e)
        {
            print '<br>Error @ thumbnail: ' . $this->image_lib->display_errors();
        }
   }
    function resize($img)
    {       
        $this->load->library('image_lib');                        
//            $config = array(
//                'image_library' => 'gd2',
//                'source_image' => $img,
//                'maintain_ratio' => TRUE,
//                'overwrite' => TRUE,
//                'height' => 150,
//                'create_thumb' => TRUE    
//            );
        $this->image_lib->initialize($config);
        $config = array(
            'image_library' => 'gd2',
            'source_image' => $img,
            'maintain_ratio' => TRUE,
            'overwrite' => TRUE,
            'width' => 239,
            'height' => 218
        );
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize())
        {
            print '<br>Error @ resize: ' . $this->image_lib->display_errors();
        }
   }
}