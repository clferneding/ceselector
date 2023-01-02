# TYPO3-Extension *ceselector*

## Content Element Selector
This frontend-plugin selects from a set of content-element records (single records and/or records from pages) and renders them.
You can choose the sorting you want to be applied to the set of records and the maximum elements to show.
One sorting option is "random", so you can show random elements out of your set.
Finally, there's a feature called 'persistent mode'. In this mode, a cookie will be used to store the selected UID's of the content-elements.
This way you can realize:

* Rotating content (e.g. The user will see a new teaser on each visit of the page)
* Keep a random selection for a certain timespan before a new random selection is made
  (you can set the cookie-expire-time)
* Step through the randomly sorted list before a new random selection will be made.

If you choose "0" for "Persistent selection expire", the cookie will expire when the browser window will be closed (may not work depending on browser/setting!).
The plugin respects versioning/localization of records.

__Sorting options:__

* Random
* Sorting ascending
* Sorting descending
* Header-text ascending
* Header-text descending

## Configuration
Add the static template of the extension to your template.

## Usage
Add the frontend plugin in your content, choose single records and/or pages/sys-folders to choose content elements from.
Set plugin preferences _Order selection by_, _Max elements to show_, _Persistent Mode_ and _Persistent selection expire_.

## Changelog

### 3.0.2
Fix composer.json

### 3.0.1
Typoscript files: change ending to .typoscript

### 3.0.0
TYPO3 9/10 compatibility; drop TYPO3 8 support   
Reset cookie data after plugin data (options) modification  
Domain\Model\Content: remove uid and pid (inherited from AbstractEntity)

### 2.0.4
Fix markdown syntax in this file

### 2.0.2

* TYPO3 8 compatibility
* composer support
* dedicated cookie for each plugin instance
* improved rotation (persistent mode)
