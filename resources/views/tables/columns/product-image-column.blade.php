<div>
    @php
        if (!empty($getRecords)) {
            if( substr($getRecord()->product_images[0]->image, 0, 6) === "images"){
                $src = "/".$getRecord()->product_images[0]->image;
            }else{
                $src = $getRecord()->product_images[0]->image;
            }
        }
    @endphp
    <img src="{{ empty($src) ? "https://via.placeholder.com/640x480.png/0000FF/FFFFFF?text=Default" : $src}}" alt="Product Image">
</div>


