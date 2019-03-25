

CREATE TABLE `bug_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `status_name` varchar(200) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `bug_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bug_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `bugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `bug_name` varchar(300) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `assigned_to` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `details` text,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `priority_name` varchar(200) NOT NULL,
  `priority_weight` int(11) NOT NULL,
  `priority_color` varchar(200) DEFAULT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `project_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(200) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(200) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `tag_name` varchar(200) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Browser'),
(2, 'Developer'),
(3, 'Project Manager');