
# WP Simple Content Filter

**WP Simple Content Filter** is a lightweight WordPress plugin that allows users to easily filter content on their website using a simple search input and multiple dropdown select fields. The plugin dynamically updates the displayed content based on user input, providing a seamless and interactive experience for visitors.

## Features

- **Dynamic Search Input**: Users can type in a search box to filter content based on visible text or HTML, including class names and other attributes.
- **Multiple Dropdowns**: Add as many dropdown select fields as needed to allow users to filter content based on various criteria.
- **Customizable Search Area**: Specify the class of the elements you want to filter with the `searchinclass` attribute.
- **Real-time Filtering**: Content updates instantly as users type or select from dropdowns.

## Usage

### Shortcode

To use the plugin, insert the following shortcode into your posts or pages:

```
[WPSimpleContentFilter showsearch=1 searchinclass="your-class-name" select1="Option 1,Option 2" select2="Value 1,Value 2"]
```

- **showsearch**: Set to `1` to display the search input field.
- **searchinclass**: Specify the class of the content area to filter.
- **select1, select2, ...**: Define dropdown options separated by commas. You can add multiple select attributes.

### Example

```html
[WPSimpleContentFilter showsearch=1 searchinclass="fusion-content-layout-column" select1="Option A,Option B" select2="Value X,Value Y"]
```

## Installation

1. Download the plugin files.
2. Upload the `wp-simple-content-filter` directory to your `wp-content/plugins` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Use the shortcode in your posts or pages to implement the content filter.

## Contributing

Contributions are welcome! If you have suggestions or improvements, please open an issue or submit a pull request.
