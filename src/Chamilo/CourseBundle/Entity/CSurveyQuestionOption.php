<?php

namespace Chamilo\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CSurveyQuestionOption
 *
 * @ORM\Table(name="c_survey_question_option")
 * @ORM\Entity
 */
class CSurveyQuestionOption
{
    /**
     * @var integer
     *
     * @ORM\Column(name="iid", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $iid;

    /**
     * @var integer
     *
     * @ORM\Column(name="c_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $cId;

    /**
     * @var integer
     *
     * @ORM\Column(name="question_option_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $questionOptionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="question_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $questionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="survey_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $surveyId;

    /**
     * @var string
     *
     * @ORM\Column(name="option_text", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $optionText;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $value;


    /**
     * Get iid
     *
     * @return integer
     */
    public function getIid()
    {
        return $this->iid;
    }

    /**
     * Set cId
     *
     * @param integer $cId
     * @return CSurveyQuestionOption
     */
    public function setCId($cId)
    {
        $this->cId = $cId;

        return $this;
    }

    /**
     * Get cId
     *
     * @return integer
     */
    public function getCId()
    {
        return $this->cId;
    }

    /**
     * Set questionOptionId
     *
     * @param integer $questionOptionId
     * @return CSurveyQuestionOption
     */
    public function setQuestionOptionId($questionOptionId)
    {
        $this->questionOptionId = $questionOptionId;

        return $this;
    }

    /**
     * Get questionOptionId
     *
     * @return integer
     */
    public function getQuestionOptionId()
    {
        return $this->questionOptionId;
    }

    /**
     * Set questionId
     *
     * @param integer $questionId
     * @return CSurveyQuestionOption
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return integer
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set surveyId
     *
     * @param integer $surveyId
     * @return CSurveyQuestionOption
     */
    public function setSurveyId($surveyId)
    {
        $this->surveyId = $surveyId;

        return $this;
    }

    /**
     * Get surveyId
     *
     * @return integer
     */
    public function getSurveyId()
    {
        return $this->surveyId;
    }

    /**
     * Set optionText
     *
     * @param string $optionText
     * @return CSurveyQuestionOption
     */
    public function setOptionText($optionText)
    {
        $this->optionText = $optionText;

        return $this;
    }

    /**
     * Get optionText
     *
     * @return string
     */
    public function getOptionText()
    {
        return $this->optionText;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return CSurveyQuestionOption
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return CSurveyQuestionOption
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}
