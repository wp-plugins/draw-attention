=== Draw Attention ===
Contributors: tylerdigital, nataliemac, croixhaug
Tags: interactive images, image maps, highlightable areas, highlight images, product images, conferences, conventions, trade shows, floor plans, virtual tour, call to action, real estate, responsive, responsive image map
Requires at least: 3.5.1
Tested up to: 4.3
Stable tag: 1.5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create interactive images in WordPress. Perfect for floor plans, trade shows, group photos, product features, and annotated image tutorials.

== Description ==

### Responsive Design ###
Interactive images resize to fit your theme and the available screen size

### Accessible ###
Image info is accessible to everyone who visits your site, regardless of device or capabilities.

### Progressively Enhanced ###
Your content is accessible even to users who have JavaScript disabled - SEO friendly too! Draw Attention uses canvas elements in modern browsers, and falls back to image maps in older browsers.

### Customizable Colors ###
Choose your own custom color scheme to match your site

### Highlight on Hover ###
Highlight different areas of your image when your site visitor moves their mouse over the interactive image

### Easy to Draw ###
Easy to draw the highlightable areas of your image - and easy to edit the shapes later too!

### More Info on Click ###
When a highlighted area is clicked, show more information.

### Go to a URL ###
Optionally send a site visitor to another URL when clicking a highlightable area of the image map.

[vimeo https://vimeo.com/138407309]

[Upgrade to Draw Attention Pro](http://wpdrawattention.com/) to get more features and customization:

### Have Multiple Interactive Images (Pro only) ###
Need more than one interactive image on your site? The Pro version allows unlimited highlightable areas on unlimited interactive images

### Layout Options (Pro only) ###
Show more info about highlighted map areas in a variety of different layouts, including lightbox and tooltip.

### 20 Pre-Defined Color Palettes (Pro only) ###
Choose from one of 20 pre-defined color palettes or use your own custom color scheme

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'draw attention'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `draw-attention.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= What's added in Draw Attention Pro? =

**The Pro version includes:**

- Ability to create more than 1 interactive image
- Unlimited number of highlightable areas for each image
- 20 preset color schemes
- Custom layout options (change position of more info box or use a lightbox or a tooltip)

== Screenshots ==
1. Draw your highlightable areas right in the dasbhoard
2. Site visitors can click to learn more about your highlighted areas
3. Upload a floor plan and show detail photos for each room
4. Customize the colors and appearance of the highlighted areas
5.

== Changelog ==

= 1.5.3 =
* Fixed: Conflict between post ID and hotspot ID caused image to disappear when clicking hotspot

= 1.5.2 =
* Fixed: Incompatibility with 3rd party theme/plugin javascript in the admin
* Fixed: Scrolling issue with deep-linked hotspots on tall vertical images

= 1.5.1 =
* Fixed: PHP warnings when WP_DEBUG was on
* Fixed: Scrolling issue with deep-linked hotspots


= 1.5 =
* New: Customize background color (behind image) with new color picker added to interface
* New: Link directly to a hotspot (right-click and copy link) - area will be highlighted automatically

= 1.4.5 =
* Fixed: Mobile/Touch events required 4 taps for areas with URL action

= 1.4.4 =
* Fixed: "the_content" always displaying in the default more info area

= 1.4.3 =
* Fixed: Loading more info in IE9 and IE10. Note that these browsers do not support the area highlights
* Fixed: Clicking off a selected area will display the default placeholder text in the more info area

= 1.4.2 =
* Fixed: Allow shortcodes in more info area, without using the_content which caused some conflicts with other plugins (ie. showing sharing buttons)

= 1.4.1 =
* New: Ability to link an area to a URL (instead of showing more info)
* New: Added Visual/WYSIWYG editor to area descriptions (more info box)
* Improved: Usability on mobile phones and touch devices
* Improved: Portuguese translation
* Fixed: Preview not working in some cases
* Fixed: Compatibility issue with Jetpack Photon

= 1.3 =
* New: Easily preview your interactive image using "Preview Changes" or "View Post" in the dashboard
* Improved: Better handling of mobile device changing orientation after interactive image is loaded
* Fixed: Interactive features not working in older versions of Internet Explorer

= 1.2 =
* New: Improve internationalization
* New: Add Portuguese translation
* Improved: Optimize detail image size (don't load full size image for more info box)
* Improved: Handle JS conflicts with other plugins better
* Improved: Add warning message for old servers running PHP 5.2 (Draw Attention requires PHP 5.3+)
* Improved: Better handling of window resizing after interactive image is loaded
* Fixed: More info content not updating in some situations
* Fixed: Conflict with some themes causing highlighted areas to "jump" when clicked

= 1.1.3 =
* Fixed: Default color scheme always applying when re-editing an existing image

= 1.1.2 =
* Fixed: PHP Warnings when PHP is in Strict Standards mode

= 1.1.1 =
* New: Add ability "click off" highlighted areas
* New: Add confirmation alert before deleting highlightable area in the dashboard
* New: CPT icon in dashboard
* New: Set a default color scheme when activating Draw Attention
* Fixed: default layout to show More Info on Left rather than on top
* Fixed: PHP Warnings visible with WP_Debug
* Fixed: issues with selected highlight color not always displaying properly

= 1.0.2 =
* Fixed: issue with saving data

= 1.0 =
* Initial Release

== Upgrade Notice ==

= 1.0 =
Initial Release
