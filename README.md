# Modified-SVG-Support-for-Divi

Modified files of the Wordpress plugin SVG Support when using Divi or Divi Child Themes.


## Overview

This is a modified version of the [**SVG Support**](https://wordpress.org/plugins/svg-support/) plugin that is "Divi friendly".

This serves as reference and possible solution for those experience similar challenges and is not the stable plugin available in the wordpress repository but a mimicked version thereof.

*The testing environment was WP 4.8 with a Divi Child theme (Divi v3.3.66 as parent theme), I have not tested it with other themes or versions of Wordpress so therefore the challenges and/or issues mentioned is considered for this specific environment ONLY.*

## The Problem

I love the [**SVG Support**](https://wordpress.org/plugins/svg-support/) plugin by [**Benbodhi**](https://github.com/benbodhi) and all the functionality it offers. I mainly use [**Divi**](http://www.elegantthemes.com) child themes for my Wordpress site designs. The benefit of SVG Support is that I now can incorporate SVG via the library but when using the divi-builder I can't add the required class in many instances, e.g., when adding a *Logo Image URL* or a *Header Image URL* in a fullwidth header module. So basically I was left with only getting full benefit of the plugin when adding a SVG in the content editor.

As a result SVG's containing embeded javascript animation inside the svg document is loaded and processed as a static image.

Initially I build a custom fullwidth header module for Divi to allow adding classes to the logo and header images but, due to Divi 3's restrictions, the custom module is not usable when using the visual builder in the front end.

Using this method would mean that would I would basically have to

1. build a custom module of almost all the Divi modules that allow including images, which would be a very tedious and lengthy excercise, and
1. My non-developer clients and myself, would lose the benefits of using the visual builder.

At this point, despite my limited knowledge of php and javascript, I decided to "tinker" with the SVG Support plugin to see if I could find an alternative method to overcome the challenges.

### SVG Support issues encountered

#### 1. Changing Class Name

In advanced mode when set to automatically add the class it's done via the "bodhi_svgs_auto_insert_class" located in 'attribute-control.php', thus when a new post/page is created containing svg's the standard html attributes inside the image tag is stripped and the default class "style-svg" or the custom class from the plugin settings, e.g. "my-class", is added.

The caveat with this method is that if at any point the class gets changed, in the SVG Support advanced settings, posts or pages created previously still have the previous class and is now ignored, thus not converted into inline svg's, as the plugin looks for images with the newly defined class.

#### 2. Featured Image

When adding a featured image to post/pages the class does gets added to the image, however in the front end the image still gets rendered as an image and not an inline svg, 
e.g. 

``` html

<a href="http://domain.com/2017/07/20/hello-world/" class="entry-featured-image-url">
    <img src="sample.svg" class="style-svg" />
</a> 

```

instead of

``` html

<a href="http://domain.com/2017/07/20/hello-world/" class="entry-featured-image-url">
    <svg>..</svg>
</a>

```

#### 3. Divi Specific Issues

Using Divi or Divi child themes or using the Divi Builder Plugin to create content in most cases doesn't allow for the CSS class the plugin requires to the image.

## The Solution

### Added functionality:

* Added option whether to use expanded or minified Javascript file in advanced settings.
* Added power override option in advanced settings which assigns svg class to all images containing a svg via jQuery.
* Added online tool links for SVG compression and SVG animation.

### What's the benefit?

You can now use SVG images, even those with internal animation, throughout your Divi build site without having to use or purchase specialised modules.

### How to use it

If you use a visual builder, like Divi, that limits the full functionality of SVG's install the [**SVG Support**](https://wordpress.org/plugins/svg-support/) plugin. To add the features listed above backup and replace the following files in the plugin folder (*wordpress/wp-content/plugins*) with the files in this repository.

svg-support *(plugin folder)*

* admin
  * *svgs-settings-page.php*
* functions
  * *enqueue.php*
* js
  * min
    * *svgs-inline-pwr-min.js*
  * *svgs-inline-pwr.js*

Go to the plugin settings and check [ ] *Enable Advanced Mode* and save, when it reloads check the [ ] *Automatically insert class* and the [ ] *Power Override: Add class to all SVG's* options and save.