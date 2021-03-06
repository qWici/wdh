<?php

namespace App\Console\Commands\Parsers;

use App\Helpers\ParseResource;
use App\Models\Channel;
use Youtube;
use Image;
use Illuminate\Console\Command;

class ParseYoutubeChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Youtube channels';

    /**
     * Youtube API key
     *
     * @var mixed
     */
    protected $youtubeKey;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $channels = ParseResource::getData('channels');
        foreach ($channels as $channel) {
            if(Channel::where('youtube_id', $channel)->exists()) {
                continue;
            }

            $channelData = Youtube::getChannelById($channel);
            if(! empty($channelData->snippet)) {
                $this->storeChannel($channelData);
            }
        }
    }

    /**
     * Store channel
     *
     * @param $channel
     */
    public function storeChannel($channel)
    {
        $newChannel = new Channel();
        $newChannel->youtube_id = $channel->id;
        $newChannel->title = $channel->snippet->title;
        $newChannel->slug = str_slug($channel->snippet->title);
        $newChannel->description = $channel->snippet->description;

        if(property_exists($channel->snippet, 'customUrl')){
            $newChannel->custom_url = $channel->snippet->customUrl;
        }
        $newChannel->image_src = $channel->snippet->thumbnails->medium->url;
        $newChannel->country = $this->getCountryProp($channel);
        $newChannel->subscriber_count = $channel->statistics->subscriberCount;
        $newChannel->save();

        $this->storeAndUpdateLogo($newChannel);
    }

    /**
     * Store channel logo to public folder in webp format
     *
     * @param $channel
     */
    public function storeAndUpdateLogo($channel)
    {
        $imageURL = $channel->image_src;
        $imagePath = "/images/channels/" . $channel->slug . ".png";
        Image::make($imageURL)->encode('png', 75)->save("public" . $imagePath);
        $channel->image_src = $imagePath;
        $channel->save();
    }


    /**
     * Check if channel snippets has property
     * Now using for check country
     *
     * @param $channel
     * @return null
     */
    public function getCountryProp($channel)
    {
        if(property_exists($channel->snippet, 'country')){
            return $channel->snippet->country;
        }

        return "EN";
    }
}
