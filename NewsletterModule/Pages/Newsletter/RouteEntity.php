<?php

namespace NewsletterModule\Pages\Newsletter;

use BlogModule\Pages\Blog\AbstractRouteEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\NewsletterModule\Pages\Newsletter\RouteRepository")
 * @ORM\Table(name="vranovsko_newsletter_route")
 */
class RouteEntity extends AbstractRouteEntity
{

}
