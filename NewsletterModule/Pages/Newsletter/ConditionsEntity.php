<?php

namespace NewsletterModule\Pages\Newsletter;

use BlogModule\Pages\Blog\AbstractRouteEntity;
use CmsModule\Content\Entities\ExtendedRouteEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\NewsletterModule\Pages\Newsletter\RouteRepository")
 * @ORM\Table(name="vranovsko_newsletter_conditions")
 */
class ConditionsEntity extends ExtendedRouteEntity
{

}
