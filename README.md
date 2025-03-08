# Personal website
My personal website is a modern homage to the '90s, serving as the dichotomy between the simple aesthetics of retro sites with the unnecessary complexity of the latest DevOps abstractions. It's built with the Jigsaw static site generator, using PHP blade templates for modularity and maintenability.

![diagram](source/assets/img/website-diagram-dark.png "Website Logical Diagram")

The entire infrastructure is hosted on AWS. I'm leveraging S3 to store the source code, Cloudfront to deploy the site globally through a CDN, an API Gateway to allow CORS requests for fonts/RSS, and the Certificate Manager for SSL encryption/authentication. 

An automated GitHub Actions workflow keeps the production site updated and manages the CloudFront distribution with every push to the master branch.

Read more about it in the <a href="https://www.xbazzi.com/projects/website/index.html">article</a>.