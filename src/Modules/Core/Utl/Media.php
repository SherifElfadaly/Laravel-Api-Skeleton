<?php namespace App\Modules\Core\Utl;

class Media
{
	/**
	 * Upload the given image.
	 * 
	 * @param  object  $image
	 * @param  string  $dir
	 * @return string
	 */
	public function uploadImage($image, $dir) 
	{
	   $imageName       = str_slug('image'.uniqid().time().'_'.$image->getClientOriginalName());
	   $destinationPath = 'media'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;

	   ! file_exists($destinationPath) ? \File::makeDirectory($destinationPath) : false;
	   $image->move($destinationPath, $imageName);

	   return url($destinationPath.$imageName);
	}

	/**
	 * Upload the given image.
	 * 
	 * @param  object  $image
	 * @param  string  $dir
	 * @return string
	 */
	public function uploadImageBas64($image, $dir) 
	{
		if ( ! strlen($image)) 
		{
			return null;
		}
        
		$imageName       = 'image'.uniqid().time().'.jpg';
		$destinationPath = 'media'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;

		! file_exists($destinationPath) ? \File::makeDirectory($destinationPath) : false;

		$base = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
		\Image::make($base)->save($destinationPath.$imageName);

		return url($destinationPath.$imageName);
	}

	/**
	 * Delete the given image.
	 * 
	 * @param  object  $path
	 * @param  string  $dir
	 * @return void
	 */
	public function deleteImage($path, $dir) 
	{   
		$arr      = explode('/', $path);
		$path     = 'media'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.end($arr);
		if (\File::exists($path)) 
		{
			\File::delete($path);
		}
	}
}
