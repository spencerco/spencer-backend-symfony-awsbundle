# November Five AWS Bundle

At the moment this bundle is primarily used for KMS, SNS, SQS.

## Installation

### Composer

        "november-five/aws-bundle": "*.*.*"

        "repositories": [
            {
                "type": "vcs",
                "url": "git@bitbucket.org:appstrakt/lib_serverside_awsbundle.git"
            }
        ],

### AppKernel

      new NovemberFive\AwsBundle\NovemberFiveAwsBundle()

### Configuration

    # config file
    november_five_aws:
        aws: # global general AWS keys
            access_key: %aws_access_key% # defaults to NULL if not set => server side doesn't need keys
            secret_key: %aws_secret_key% # defaults to NULL if not set => server side doesn't need keys
            region: %aws_region% # default set to eu-west-1
            proxy: %proxy% # default set to NULL
        sqs: # SQS specific stuff
            version ~ # default 2012-11-05
        sns: # SNS specific stuff
            version ~ # default 2010-03-31
        kms: # KMS specific stuff
            secret: %aws_kms_key% # optional - defaults to null
            version: ~ # default 2014-11-01
        s3: # S3 specific stuff
            version: ~ # default 2006-03-01
        lambda: # Lamnda specific stuff
            version: ~ # default latest

## Usage

    You can find the documentation for every service in `Resources/docs`.

### Releases

__1.2.1 (2018/04/26)__

* Updated services.yml to make class namespaces compatible with Symfony 3

__1.2.0 (2018/04/26)__

* Updated the credentials configuration to support v3 of the AWS SDK. This should be backwards compatible with v2.

__1.1.2 (2018/02/28)__

* Typo: Fixed typo in Readme

__1.1.1 (2018/01/15)__

* Fixed bug: Update NovemberFiveUtilityExtension.php to only use Yaml::parse() in symfony version < 3.

__1.1.0 (2018/01/01)__

* Update NovemberFiveUtilityExtension.php: replace Yaml::parse() with Yaml::parseFile() to support Symfony 3. Fallback still supported for Symfony < 3

__1.0.2 (2017/12/08)__

* Added platform attributes lookup in SNSManager

__1.0.1 (2017/11/20)__

* Fixed typo in docs

__1.0.0 (2017/11/20)__

* Implemented the LambdaManager

__0.9.0 (2017/09/19)__

* Implemented the S3Manager
