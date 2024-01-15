<?php

namespace App\Lib;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\GeneralSetting;

class System
{
    public function __construct()
    {
		
    }

	public function slug_format($word)
	{
		$word = stripslashes($word);
		$word = strip_tags($word);
		$word = str_replace("/", "_", $word);
		$word = str_replace("}", "_", $word);
		$word = str_replace("{", "_", $word);
		$word = str_replace(" ", "_", $word);
		$word = strtolower($word);
		
		return $word;
	}
	
	public function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) 
	{
		$dates = [];
		$current = strtotime( $first );
		$last = strtotime( $last );

		while( $current <= $last ) {

			$dates[] = date( $format, $current );
			$current = strtotime( $step, $current );
		}

		return $dates;
	}
	
	public function decode_chunk( $data ) 
    {
		$data = explode( ';base64,', $data );

		if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
			return false;
		}

		$data = base64_decode( $data[1] );
		if ( ! $data ) {
			return false;
		}
		
		$imageName = rand(10000000, 90000000).'-'.time().'.'.'png';
        Storage::disk('photos')->put($imageName, $data);
        $content = Storage::disk('photos')->url($imageName);
        return $content;
	}
	
	public function decode_chunk_small_size( $data ) 
    {
		$data = explode( ';base64,', $data );

		if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
			return false;
		}

		$data = base64_decode( $data[1] );
		if ( ! $data ) {
			return false;
		}
		$image = collect();
		$image->name = rand(10000000, 90000000).'-'.time().'-sm.'.'png';
		$image->width = 250;
				
        Storage::disk('photos')->put($image->name, $data);
        $content = Storage::disk('photos')->url($image->name);
        
        $img = Image::make($content);
        $img->resize($image->width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
		$img->save(storage_path()."/app/public/photos/".$image->name,100);
				
        return $content;
	}
	
	public function decode_chunk_big_size( $data ) 
    {
		$data = explode( ';base64,', $data );

		if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
			return false;
		}

		$data = base64_decode( $data[1] );
		if ( ! $data ) {
			return false;
		}
		$image = collect();
		$image->name = rand(10000000, 90000000).'-'.time().'-lg.'.'png';
		$image->width = 600;
				
        Storage::disk('photos')->put($image->name, $data);
        $content = Storage::disk('photos')->url($image->name);
        
        $img = Image::make($content);
        
        if ($img->width() > 600)
		{
			$img->resize($image->width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
			$img->save(storage_path()."/app/public/photos/".$image->name,100);
		}
        
        return $content;
	}
	
	public function decode_chunk_custom_size( $data, $size ) 
    {
		$data = explode( ';base64,', $data );

		if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
			return false;
		}

		$data = base64_decode( $data[1] );
		if ( ! $data ) {
			return false;
		}
		$image = collect();
		$image->name = rand(10000000, 90000000).'-'.time().'-cs.'.'png';
		$image->width = $size;
				
        Storage::disk('photos')->put($image->name, $data);
        $content = Storage::disk('photos')->url($image->name);
        
        $img = Image::make($content);
        
        if ($img->width() > $image->width)
		{
			$img->resize($image->width, null, function ($constraint) {
																							$constraint->aspectRatio();
																						  });
			$img->save(storage_path()."/app/public/photos/".$image->name,100);
		}
        
        return $content;
	}
	
	public function total_minutes($start, $end)
	{
		//~ $start_date = date_create($start);
		//~ $end_date = date_create($end);
		
		//~ $since_start = $start->diff($end);

		//~ $minutes = $since_start->days * 24 * 60;
		//~ $minutes += $since_start->h * 60;
		//~ $minutes += $since_start->i;
		//~ return $minutes;
		
		$to_time = strtotime($start);
		$from_time = strtotime($end);
		return round(($to_time - $from_time) / 60,2);
	}
	
}
