# GoForum [![Build Status](https://travis-ci.org/MagedAhmad/GoForum.svg?branch=master)](https://travis-ci.org/MagedAhmad/GoForum)

This is an open source forum

## Installation

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart). 

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone https://github.com/MagedAhmad/GoForum.git
cd GoForum 
cp .env.example .env
php artisan key:generate
composer install 
npm install
npm run dev
```
