<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\EarlyAccess
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess query()
 */
	class EarlyAccess extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read string $photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OAuthProvider[] $oauthProviders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Channel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 */
	class Channel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Podcast
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @property-read \App\Models\PodcastShow $show
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast query()
 */
	class Podcast extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Author
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author query()
 */
	class Author extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Suggestion
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion query()
 */
	class Suggestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StreamTag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stream[] $stream
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag query()
 */
	class StreamTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Video
 *
 * @property-read \App\Models\Channel $channel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video query()
 */
	class Video extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article
 *
 * @property-read \App\Models\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PodcastShow
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Podcast[] $podcasts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow query()
 */
	class PodcastShow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Content
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $contentable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content query()
 */
	class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stream
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StreamTag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream online()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream query()
 */
	class Stream extends \Eloquent {}
}

namespace App{
/**
 * App\OAuthProvider
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider query()
 */
	class OAuthProvider extends \Eloquent {}
}

