<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'shop_id', 'activated', 'redirect_product_page', 'disable_guests', 'wishlist_btn_size', 'wishlist_btn_color', 'is_heart_icon', 'is_wishlist_collection', 'share_social_media', 'reminder_mail', 'mail_recursive_days', 'wishlist_label_btn'
    ];
}
