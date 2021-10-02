<?php

use App\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class frontSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Media::insert([
            [
                'image' => 'banner.jpg',
                'have_content' => 'yes',
                'content' => '<div class="itemBox text-center">
                    <h2>Honest Beauty</h2>
                    <h1>20% Discount On All Services</h1>
                    <p>Also Get E-Gift Cards Up To Rs. 10000</p>
                </div>',
                'action_button' => 'login',
                'url' => route('login'),
                'open_tab' => 'current',
                'content_alignment' => 'left'
            ],
            [
                'image' => 'banner5.jpg',
                'have_content' => 'yes',
                'content' => '<div class="itemBox text-center">
                    <h2>Honest Beauty</h2>
                    <h1>20% Discount On All Services</h1>
                    <p>Also Get E-Gift Cards Up To Rs. 10000</p>
                </div>',
                'action_button' => 'login',
                'url' => route('login'),
                'open_tab' => 'new',
                'content_alignment' => 'right'
            ],
            [
                'image' => 'banner3.jpg',
                'have_content' => 'no',
                'content' => '',
                'action_button' => '',
                'url' => '',
                'open_tab' => '',
                'content_alignment' => ''
            ],
            [
                'image' => 'banner2.jpg',
                'have_content' => 'yes',
                'content' => '<div class="itemBox text-center">
                    <h2>Honest Beauty</h2>
                    <h1>20% Discount On All Services</h1>
                    <p>Also Get E-Gift Cards Up To Rs. 10000</p>
                </div>',
                'action_button' => 'login',
                'url' => route('login'),
                'open_tab' => 'current',
                'content_alignment' => 'left'
            ],
            [
                'image' => 'banner4.jpg',
                'have_content' => 'no',
                'content' => '',
                'action_button' => '',
                'url' => '',
                'open_tab' => '',
                'content_alignment' => ''
            ],
        ]);

        $path = base_path('public/user-uploads/' . 'sliders' . '/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        File::copy(public_path('front/images/banner.jpg'), public_path('user-uploads/sliders/banner.jpg'));
        File::copy(public_path('front/images/banner2.jpg'), public_path('user-uploads/sliders/banner2.jpg'));
        File::copy(public_path('front/images/banner3.jpg'), public_path('user-uploads/sliders/banner3.jpg'));
        File::copy(public_path('front/images/banner4.jpg'), public_path('user-uploads/sliders/banner4.jpg'));
        File::copy(public_path('front/images/banner5.jpg'), public_path('user-uploads/sliders/banner5.jpg'));

    }
}
