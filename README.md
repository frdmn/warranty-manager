# crtmgmt

![](http://i.imgur.com/xHDu6a7.png)

Simple web app to keep track of your TLS/SSL certificates: How long they are valid? Which ones are due for renewal? Where and what for are they in use (e.g. wild card certificates)?

## Installation

1. Make sure you've installed all requirements
2. Clone this repository:
  `git clone https://github.com/frdmn/crtmgmt`
3. Install dependencies using `npm` and `bower`:  
  `composer install` (for PHP dependencies)  
  `npm install` (for Node dependencies)  
  `bower install` (to download all web libraries)  
4. Compile assets using Gulp:  
  `gulp`
5. Start web server:  
  `gulp dev`  

## Contributing

1. Fork it
2. Create your feature branch: `git checkout -b feature/my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin feature/my-new-feature`
5. Submit a pull request

## Requirements / Dependencies

* NodeJS
* Gulp/Bower CLI (`npm install -g gulp bower`)
* PHP/Composer

## Version

1.0.0

## License

[MIT](LICENSE)
