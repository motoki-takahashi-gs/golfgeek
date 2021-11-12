<?php

require_once __DIR__ . '/../includes/functions.php';

class LessonCourses extends Dbh
{
    private $row;
    private $courseList;
    private $courseOptions;

    private function selectLessonCourse()
    {
        $sql = 'SELECT id, name_ja FROM courses ORDER BY id ASC';
        $sth = $this->connectDatabase()->prepare($sql);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function setCourseList()
    {
        $sth = $this->selectLessonCourse();
        $this->courseList .= '<ul>';
        while ($this->row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->courseList .= '<li>';
            $this->courseList .= '<a href="?id=' . $this->row['id'] . '">';
            $this->courseList .= $this->row['name_ja'] . 'コース';
            $this->courseList .= '</a>';
            $this->courseList .= '</li>';
        }
        $this->courseList .= '</ul>';
    }

    public function getCourseList()
    {
        return $this->courseList;
    }

    public function setCourseOptions($courseId)
    {
        $sth = $this->selectLessonCourse();
        while ($this->row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($this->row['id'] == $courseId) ? ' selected' : '';
            $this->courseOptions .= '<option' . $selected . ' value="' . $this->row['id'] . '">';
            $this->courseOptions .= $this->row['name_ja'];
            $this->courseOptions .= '</option>';
        }
    }

    public function getCourseOptions()
    {
        return $this->courseOptions;
    }
}
