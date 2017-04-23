<?php

/*
 * This file is part of the Beloop package.
 *
 * Copyright (c) 2016 AHDO Studio B.V.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Arkaitz Garro <arkaitz.garro@gmail.com>
 */

namespace Beloop\Web\TypeformResultsBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Beloop\Component\Course\Entity\Interfaces\CourseInterface;
use Beloop\Component\Typeform\Entity\TypeformQuiz;
use Beloop\Component\User\Entity\Interfaces\UserInterface;

/**
 * Class TypeformResultsController
 *
 * @Route(
 *      path = "/quiz-results",
 * )
 */
class TypeformResultsController extends Controller
{
    /**
     * List of quiz results
     *
     * @return array
     *
     * @Route(
     *      path = "/list",
     *      name = "beloop_my_results",
     *      methods = {"GET"}
     * )
     *
     * @Template
     */
    public function listAction()
    {
        $user = $this->getUser();
        $courses = $user->getCourses();

        $quizzes = [];
        $scores = [];

        foreach ($courses as $course) {
            $quizzes[$course->getCode()] = $this->extractQuizesFromCourse($course, $user);
            // TODO: perform an asynchronous request on frontend side
            $scores[$course->getCode()] = $this->getScoresForQuizes($quizzes[$course->getCode()], $user->getEmail());
        }

        return [
            'section' => 'my-results',
            'user' => $user,
            'courses' => $courses,
            'quizzes' => $quizzes,
            'scores' => $scores,
        ];
    }

    /**
     * @param CourseInterface $course
     * @param UserInterface $User
     * @return array Extract quiz codes from course
     */
    private function extractQuizesFromCourse(CourseInterface $course, UserInterface $user) {
        $quizes = [];

        foreach ($course->getLessons() as $lesson) {
            foreach ($lesson->getModules() as $module) {
                if ($module->isAvailableForUser($user) & $module->getType() === TypeformQuiz::TYPE) {
                    $quizes[$module->getId()]['name'] = $module->getLesson()->getName();
                    $quizes[$module->getId()]['uid'] = $module->getFormUID();
                }
            }
        }

        return $quizes;
    }

    private function getScoresForQuizes($quizes, $email) {
        $scoreService = $this->get('beloop.typeform.score_retriever_service');
        $scores = [];

        foreach ($quizes as $quiz) {
            $scores[$quiz['uid']] = $scoreService->getScoreFromUID($quiz['uid'], $email);
        }

        return $scores;
    }
}
