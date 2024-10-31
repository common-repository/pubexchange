=== PubExchange ===
Contributors: PubExchange
Tags: content recommendations, pubexchange, discovery, traffic partnership, popular posts, posts, related, Related Content, related post thumbnails, related posts, similar posts, widgets, recommendations, thumbnails, traffic, widget
Requires at least: 3.0
Tested up to: 6.5.2
Stable tag: trunk
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Use the PubExchange widget to promote content from the sites that you have partnered with through PubExchange.com

== Description ==
PubExchange is a platform that helps publishers find sites to partner with so that they can promote one another via widgets, links shared on social, or links in articles. When a publisher sends traffic to their partners, PubExchange helps ensure that those partners send an equal amount of traffic back.

This plugin enables you to add PubExchange's partner widgets to your site. The widget will automatically display links to your partners' articles and our algorithms will help determine which articles perform best on your site. If you want to exclude any articles from displaying or hand-pick specific content from each of your partners, you can do that through the PubExchange dashboard.

== Installation ==

= Requirements =
* PHP 5.2 or higher
* WordPress v3.0.x or higher

= Installation Process =
* Log into the WordPress admin for your site
* Go to 'Plugins' -> 'Add New'
* Search for PubExchange. Once found click on 'Install Now'
* Select 'Activate Plugin' from the download page or go to 'Plugins' -> 'Installed Plugins' -> 'Activate Plugin'

= Below Article widgets =
* Click on the 'Settings' link in left rail and go to the 'PubExchange' menu item.
* Enter the 'Publication ID', 'Widget ID', and 'Widget Number' received from your PubExchange representative
* Click 'Apply Changes'
* Contact a PubExchange representative to activate your account, so that your widget can begin to display

= Sidebar widgets =
* Click on the 'Settings' link in left rail and go to the 'PubExchange' menu item.
* Enter the 'Publication ID' received from your PubExchange representative and leave the 'Widget ID' and 'Widget Number' fields blank
* Click 'Apply Changes'
* Go to Appearance -> Widgets
* Drag the 'PubExchange' widget to where you would like it to be located
* Enter the 'Widget ID' and 'Widget Number' received from your PubExchange representative
* Click 'Save'
* Contact a PubExchange representative to activate your account, so that your widget can begin to display

== Frequently Asked Questions ==
= How do I use PubExchange's plugin? =
You must first contact us at PubExchange.com and if you qualify, we will get you started by setting up your profile in PubExchange so you can begin to put partnerships together. We will then provide you with your 'Publication ID' and your 'Widget Number'. After that, once you've established at least one partnership, and signed our distribution agreement, we can activate your account and 

= To generate the most traffic where should I place widgets on my site? =
Directly below articles is the best place to integrate our widget. Once the user has finished reading an article and is looking for something to do next our widget will display content from your partners.

= Will the widget slow down my site? =
No. The PubExchange widget loads "asynchronously". This means your page will load independently of the widget script. There is also an option to "lazy load" the widget which means that the widget will not begin to display until the reader scrolls down to where the widget will display.

= How do I customize the UI of PubExchange's widgets? =
Your PubExchange representative will work with you to customize your widget to match your site, but you can also make changes to the design through the PubExchange dashboard. If you would like any help, please contact us at PubExchange.com

= Will using a PubExchange widget affect my site's SEO or Google AdSense? =
No. All links within your PubExchange widget are tagged [rel=nofollow](https://support.google.com/webmasters/answer/96569 "explanation of rel=nofollow by Google"), which means that there is no SEO impact on your site or your partners' sites.

= How much does it cost to use PubExchange? How does PubExchange make money? =
If you qualify, you are able to use PubExchange at no cost. All traffic trades in PubExchange are free and unlimited, however sites are able to purchase incremental traffic from their partners on a cost-per-click basis. If any of your partners are purchasing traffic, your widget will display their content a little more frequently and you'll earn money for the incremental traffic you send them. We take a share of that, which is how we make money as well.

= How do I know if my site will qualify to join PubExchange? =
[Apply at PubExchange.com](https://www.pubexchange.com/#sign-up "Sign-up today!") and we will let you know! We consider a site's size, the quality of content, the number of social followers, and a handful of other factors, but even if you don't qualify now, if you apply online, we will automatically follow-up once you do qualify.

== Changelog ==
= Upgrading to >= 2.0 =
In PubExchange >= 2.0, you now need to provide a Widget Number in addition to a Widget ID. You can get this number from the PubExchange dashboard, or by contacting a PubExchange representative.

== Changelog ==
= 2.0.3 =
* Updated code for PHP7 compatibility

= 2.0.2 =
* Added tracking to Facebook Instant Article RSS feed, if publisher uses Wordpress' official Instant Article plugin

= 2.0.1 =
* Added Lazy Load functionality, which defers the loading of the widget until the reader scrolls down to where the widget will display
* Added Link Discovery functionality, which automtically tracks the clicks of partner links in your article content
* Decreased load time of widget code

= 1.0.1 =
* Initial release