# YiiFeed API v1

## Authentication
The `ACCESS-TOKEN` can be obtained in your personal account.

### Access token (sent in a header)
`curl -H "Authorization: Bearer ACCESS-TOKEN" https://yiifeed.com/api/v1`

### Access token (sent in query)
`curl https://yiifeed.com/api/v1?access-token=ACCESS-TOKEN`

### Basic Authentication
`curl -u "login:password" https://yiifeed.com/api/v1`


## Endpoints

Base URL is `https://yiifeed.com/api/v1`.

### Current user profile <a href="#current-profile" id="current-profile">#</a>

In order to get current user profile, use the following request:

> GET [/profile](/api/v1/profile)


### News

#### News object <a href="#news-object" id="news-object">#</a>

Each news contains the following fields:

- `id` - ID.
- `title` - Title.
- `text` - Text.
- `link` - Url to the source. 
- `status` - It can take the following values: 
    - `1`: proposed; 
    - `2`: published;
    - `3`: rejected.
- `createdAt` - UNIX timestamp indicating when news was created.
- `user` - Creator as user object.
- `siteUrl` - Url to news page on site.

#### Particular news <a href="#news-view" id="news-view">#</a>

In order to get particular news, use the following request:

> GET [/news/1](/api/v1/news/1)

#### List <a href="#news-list" id="news-list">#</a>

In order to list news use the following request:

> GET [/news](/api/v1/news)

#### Filtering list <a href="#news-search" id="news-search">#</a>

You may pass additional parameters when querying a list:

> GET [/news?userId=1](/api/v1/news?userId=1)

- `id` - ID.
- `title` - String that should be contained within news title.
- `text` - String that should be contained within news text.
- `link` - String that should be contained within url to source. 
- `status` - Status of a news as integer. 
- `userId` - ID creator of a news.


### Users

#### User object <a href="#user-object" id="user-object">#</a>

Each user contains the following fields:

- `id` - ID.
- `username` - Username.
- `status` - It can take the following values: 
    - `0`: deleted;
    - `10`: active.
- `siteUrl` - Url to user page on site. 

#### Particular user <a href="#user-view" id="user-view">#</a>

In order to get particular user, use the following request:

> GET [/users/1](/api/v1/users/1)

#### List <a href="#user-list" id="user-list">#</a>

In order to list user use the following request:

> GET [/users](/api/v1/users)
