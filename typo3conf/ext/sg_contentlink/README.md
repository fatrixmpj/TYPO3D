# Ext: sg_contentlink

<img src="https://www.sgalinski.de/typo3conf/ext/project_theme/Resources/Public/Images/logo.svg" />

License: [GNU GPL, Version 2](https://www.gnu.org/licenses/gpl-2.0.html)

Repository: https://gitlab.sgalinski.de/typo3/sg_contentlink

Please report bugs here: https://gitlab.sgalinski.de/typo3/sg_contentlink

TYPO3 version: >7.6 

## About
Adds an option to content elements that creates a link which wraps the entire element. Inner links will be removed.

## Installation & Configuration

1. Install the extension "sg_contentlink" in your TYPO3 extension manager
2. Include the static TypoScript template "Contentlink" to the root page
3. The most important **CTypes** are already added.
If you want to add a new **CType**, simply extend the tt_content **cType** values to the **SGalinski\SgContentlink\TCA\TcaProvider** class by using the following functions,
   either in your ext_tables.php or in your TCA configuration of your template extension. 
    ```
        \SGalinski\SgContentlink\TCA\TcaProvider::addAllowedTypeForContentLink('###MY_CTYPE###');
        
        // Example
        \SGalinski\SgContentlink\TCA\TcaProvider::addAllowedTypeForContentLink('media');
    ```
## Settings
You can supply different values for the link properties within the extensions TypoScript:

		 plugin.tx_sgcontentlink {
			settings {
				link {
					overwrite {
						# sets the target attribute of the generated link
						defaultTarget =
						# sets the class attribute of the generated link
						defaultClass =
						# sets the title attribute of the generated link
						defaultTitle =
					}
				}
			}
		 }
     
## Usage
In your content elements you find an option **Content Element Link**. 
When you provide a valid url, the element gets wrapped with the link and all inner links are removed. 
If the option is empty or is not a valid url, nothing happens.