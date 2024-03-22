# ECF-Studi_Garage

___
## Install
### Pre-requis:

- PHP 8.3 ou supperieur
- Composer
- (Optionelle mais recomandé) Symfony CLI

### Packages supplémentaire utilisés:

- [VichUploader](https://github.com/dustin10/VichUploaderBundle)
- [liiip-imagine](https://github.com/liip/LiipImagineBundle)

```cmd
symfony new Garage --webapp
cd Garage
composer require vich/uploader-bundle
composer require liip/imagine-bundle
```

Suivre les procédures d'instalation pour [liip](https://symfony.com/bundles/LiipImagineBundle/current/installation.html) et [vich](https://github.com/dustin10/VichUploaderBundle/blob/master/docs/installation.md)
___
## Initialiser la Base de donnee:

### Creation de l'utilisateur:
Creer l'utilisateur via l'interface avec le lien /register

