# Documentation

# SEO
### Robot.txt file 
1. file `app/Library/RobotsDotText.php` :
```php
namespace App\Library;

use Medboubazine\LaravelHelpers\Classes\Seo\Robots\Elements\RobotsDotTextUserAgentElement;
use Medboubazine\LaravelHelpers\Classes\Seo\Robots\RobotsDotTextGenerator;

class RobotsDotText extends RobotsDotTextGenerator
{
    public function __construct()
    {
        parent::init(new RobotsDotTextUserAgentElement("*", ["/something"]));
        parent::init(new RobotsDotTextUserAgentElement("GoogleBot", ["/path-1"]));
        parent::init(new RobotsDotTextUserAgentElement("MicrosoftBot", ["/path-2"]));
    }
}

```
2. RUN command:
```bash
php artisan medboubazine:seo:robots -C "App\Library\RobotsDotText"
```

### sitemap.xml file
1. file `app/Library/Sitemaps.php` :
```php

namespace App\Library;

use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\Elements\SitemapGeneratorElement;
use Medboubazine\LaravelHelpers\Classes\Seo\Sitemap\SitemapGenerator;

class Sitemaps extends SitemapGenerator
{
    public function __construct()
    {
        parent::__construct();
        /**
         * This will create a sitemap file for given routes 
         */

        $foo = new SitemapGeneratorElement(
            "foo.xml",
            public_path("sitemaps"),
            [
                "abcd",
                "xyz",
            ]
        );
        $this->create_sub($foo);

        /**
         * This will create a sitemap file contain all sitemaps on the given path
         */
        $root = new SitemapGeneratorElement(
            "sitemap.xml",
            public_path("sitemaps"),
            []
        );
        $this->create_root($root);
    }
}
```
2. RUN command:
```bash
php artisan medboubazine:seo:sitemaps -C "App\Library\Sitemaps"
```

