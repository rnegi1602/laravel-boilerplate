<?php

namespace App\Services; 

use Image;

class ImageService
{
    protected $image_path;
    protected $errors = [];
    protected $with_date_folders = true;
    protected $image_name;
    protected $image_width;
    protected $image_height;
    protected $date_folders;  
    protected $image; 
    protected $retain_ratio = false;
    protected $target_folder = '';

    public function __construct()
    {
        ini_set('memory_limit','256M');
    }

    /**
     * Initiate an image to process!
     * @params obj $image, string $target_folder, int $image_width, int $image_height, bool $retain_ratio
     * 
     * @return current instance
     */
    public function init($image, $target_folder = '', $image_width = null, $image_height = null, $retain_ratio = false)
    {
        $this->image = $image;
        $this->image_width = $image_width;
        $this->image_height = $image_height;
        $this->retain_ratio = $retain_ratio;
        $this->target_folder = $target_folder;
        $this->setImageName(); 
        $this->image = Image::make($this->image->getRealPath());
        return $this;
    }
    
    public function upload()
    {                      
        $this->buildImagePath();

        if ($this->retain_ratio) {

            $this->resizeConstraint();

        } else {

            $this->resize();

        }

        return ($this->saveImage()) ? $this->date_folders . '/' . $this->image_name : false;
    }
    
    /**
     * Make image name
     *
     * @Param string #file extension
     */
    private function setImageName()
    {
        $this->image_name = mt_rand(1, 10000). '-' . time() . '.' . $this->image->getClientOriginalExtension();
    }
    
    /**
     * Save the uploaded image!
     *
     * Return Boolean
     */
    private function saveImage()
    {
        return $this->image->save($this->image_path . '/' . $this->image_name);        
    }

    /**
     * Resize without constraint!
     */
    public function resize()
    {
        $this->image->resize($this->image_width, $this->image_height);
    }

    /**
     * Resize with aspect ratio constraint!
     */
    public function resizeConstraint()
    {
        $this->image->resize($this->image_width, $this->image_height, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
    
    /**
     * Build the path to the image destination
     */
    public function buildImagePath()
    {
        $root_path = public_path('/images/') . $this->target_folder;
        $this->setDatesFolders($root_path);
        $this->image_path = ($this->with_date_folders) ? $root_path . '/' . $this->date_folders . '/' : $root_path . '/';
    }
  
    
    /**
     * Get the dates folders!
     */
    public function setDatesFolders($root_path)
    {
        $folder_year = date('Y');
		$folder_month = date('m');
		
        if (! file_exists($root_path . "/" . $folder_year)) {
            
	        mkdir($root_path . "/" . $folder_year, 0755, true);
            
        }
		
		if (! file_exists($root_path . "/" . $folder_year . "/" . $folder_month)) {
            
	        mkdir($root_path . "/" . $folder_year . "/" . $folder_month, 0755, true);
            
        }
        $this->date_folders = $folder_year . "/" . $folder_month;
    }
    
    /**
     * Remove teams old image!
     */
    public function deleteImage($image, $folder)
    {
		$full_path = public_path('/images/' . $folder . '/' . $image); 
		if (file_exists($full_path)) {
            
            unlink($full_path);
            
        }
    }

    /**
     * Crop an image!
     * @params int $x, int $y
     * 
     * @return current instance
     */
    public function crop(int $x, int $y)
    {
        $this->image->crop((int) $this->image_width, (int) $this->image_height, $x, $y);
        return $this;
    }
}