<?php

namespace AppBundle\Entity;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends \Doctrine\ORM\EntityRepository {
	/**
	 * Devuelve todas las notificaciones ordenadas por fecha.
	 *
	 * @see \Doctrine\ORM\EntityRepository::findAll()
	 */
	public function findAll() {
		$manager = $this->getEntityManager ();

		$dql = "SELECT n FROM BackBundle:Notificacion n ORDER BY n.fecha asc";
		$result = $manager->createQuery ( $dql )->getResult ();

		return $result;
	}
}