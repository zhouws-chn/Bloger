/*
 Navicat Premium Data Transfer

 Source Server         : blog_data
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : localhost:3306
 Source Schema         : blog_data

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 07/11/2019 14:58:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章标题',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章内容',
  `abstract_is` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否有摘要',
  `abstract` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章摘要',
  `author_id` int(11) NOT NULL COMMENT '作者id',
  `title_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章封面',
  `origin_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '来源Url',
  `cate_id` int(4) NULL DEFAULT NULL COMMENT '所属类别',
  `cate_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pv` int(255) NOT NULL DEFAULT 0 COMMENT '阅读量',
  `create_time` int(20) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(20) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `title`(`title`) USING BTREE,
  INDEX `cate`(`cate_id`) USING BTREE,
  INDEX `cate_name`(`cate_name`) USING BTREE,
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `cates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`cate_name`) REFERENCES `cates` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES (10, '计算机软件质量保证计划规范（GB/T 12504-90 ）', '<p style=\"text-indent:28px\">1 <span style=\"font-family:宋体\">主题内容与适用范围</span> </p><p><span style=\"font-family:宋体\">　　本规范规定了在制定软件质量保证计划时应该遵循的统一的基本要求。</span><br/> <span style=\"font-family:宋体\">　　本规范适用于软件特别是重要软件的质量保证计划制订工作。对于非重要软件或已经开发好的软件，可以采用本规范规定的要求的子集。</span> </p><p>　　2 <span style=\"font-family:宋体\">引用标准</span> </p><p>　　GB/T 11457 <span style=\"font-family:宋体\">软件工程术语</span><br/> 　　GB 8566 <span style=\"font-family:宋体\">计算机软件开发规范</span><br/> 　　GB 8567 <span style=\"font-family:宋体\">计算机软件产品开发文件编制指南</span><br/> 　　GB/T 12505 <span style=\"font-family:宋体\">计算机软件配置管理计划规范</span> </p><p>　　3 <span style=\"font-family:宋体\">术语</span> </p><p><span style=\"font-family:宋体\">　　下面给出本规范中用到的一些术语的定义，其他术语的定义按</span>GB/T 11457<span style=\"font-family:宋体\">。</span> </p><p>　　3.1<span style=\"font-family:宋体\">项目委托单位</span> project entrust organization</p><p><span style=\"font-family:宋体\">　　项目承办单位是指为产品开发提供资金并通常也是（但有时也未必）确定产品需求的单位或个人。</span> </p><p>　　3.2<span style=\"font-family:宋体\">项目承办单位</span>project undertaking organization</p><p><span style=\"font-family:宋体\">　　项目承办单位是指为项目委托单位开发、购置或选用软件产品的单位或个人。</span> </p><p>　　3.3<span style=\"font-family:宋体\">软件开发单位</span> software development organization</p><p><span style=\"font-family:宋体\">　　软件开发单位是指直接或间接项目委托单位委托而直接负责开发软件的单位或个人。</span> </p><p>　　3.4<span style=\"font-family:宋体\">用户</span> user</p><p><span style=\"font-family:宋体\">　　用户是指实际使用软件来完成某项计算、控制或数据处理等任务的单位或个人。</span> </p><p>　　3.5 <span style=\"font-family:宋体\">软件</span> software <span style=\"font-family:宋体\">软件开发网</span> </p><p><span style=\"font-family:宋体\">　　软件是指计算机程序及其有关的数据和文档，也包括固化了的程序。</span> </p><p>　　3.6<span style=\"font-family:宋体\">重要软件</span> critical software</p><p><span style=\"font-family:宋体\">软件开发网</span></p><p><span style=\"font-family:宋体\">　　重要软件是指它的故障会影响到人身安全、会导致重大经济损失或社会损失的软件。</span> </p><p>　　3.7<span style=\"font-family:宋体\">软件生存周期</span> software life cycle http://www.mscto.com</p><p><span style=\"font-family:宋体\">　　软件生存周期进指从系统对计算机软件系统提出应用需求开始，经过开发，产生一个满足需求的计算机软件系统，然后投入运行，直至该软件系统退役为止。期间经历系统分析与软件定义、软件开发以及系统的运行与维护等三个阶段。其中软件开发阶段一般又划分成需求分析、概要设计、详细设计、编码与单元测试、组装与系统测试发及安装与验收等六个阶段。</span> </p><p>　　3.8<span style=\"font-family:宋体\">验证</span> verification</p><p><span style=\"font-family:宋体\">　　验证是指确定软件开发周期中的一个给定阶段的产品是否达到在上一阶段确立的需求的过程。</span> </p><p>　　3.9<span style=\"font-family:宋体\">确认</span> validation</p><p><span style=\"font-family:宋体\">　　确认是指在软件开发过程结束时对软件进行评价以确定它是否和软件需求相一致的过程。</span> </p><p>　　3.10<span style=\"font-family:宋体\">测试</span> testing</p><p><span style=\"font-family:宋体\">　　测试是指通过执行程序来有意识地发现程序中的设计错误和编码错误的过程。测试是验证和确认的手段之一。</span> </p><p>　　3.11<span style=\"font-family:宋体\">软件质量</span> software quality</p><p><span style=\"font-family:宋体\">　　软件质量是指软件产品中能满足给定需求的各种特性和总和。这些特性称做质量特性，它包括功能度、可靠性、时间经济性、资源经济性、可维护性和或移植性等。</span> <br/> <br/> 　　3.12<span style=\"font-family:宋体\">质量保证</span> quality assurance</p><p><span style=\"font-family:宋体\">　　质量保证是指为使软件产品规定需求所进行的一系列有计划的必要工作。</span> </p><p>　　4 <span style=\"font-family:宋体\">软件质量保证计划编制大纲</span> </p><p><span style=\"font-family:宋体\">　　项目承办单位（或软件开发单）中负责软件质量保证的机构或个人，必须制订一个包括以下各章内容的软件质量保证计划（以下简称计划）。名章应以所给出顺序排列；如果某本章中没有相应的内容，则在该章标题之后必须注明</span>“<span style=\"font-family:宋体\">本章无内容</span>”<span style=\"font-family:宋体\">的字样，并附上相应的理由；如果需要，可以在后面增加章条；如果某些材料已经出现在其他文档中，则在该计划中应引用那些文档。计划的封面必须标明计划名和该计划所属的项目名，并必须由项目委托单位和项目承办单位（或软件开发单位）的代表共同签字，、批准。计划的目次是：</span></p><p>4.1<span style=\"font-family:宋体\">引言</span> </p><p>　　4.1.1<span style=\"font-family:宋体\">目的</span> </p><p><span style=\"font-family:宋体\">　　本条必须指出特定的软件质量保证计划的具体目的。还必须指出该计划所针对的软件项目（及其所属的各个子项目）的名称和用途。</span> </p><p>　　4.1.2<span style=\"font-family:宋体\">定义和缩写词</span> </p><p><span style=\"font-family:宋体\">　　本条应该列出计划正文中需要解释的而在</span>GB/T 11457<span style=\"font-family:宋体\">中尚未包含的术语的定义，必要时，还要给出这些定义的英文单词及其缩写词。</span> </p><p>　　4.1.3<span style=\"font-family:宋体\">参考资料</span> </p><p><span style=\"font-family:宋体\">　　本适可而止必须列出计划正文中所引用资料的名称、代号、编号、出版机构和出版年月。</span> </p><p><span style=\"font-family:宋体\">软件开发网</span></p><p>　　4.2 <span style=\"font-family:宋体\">管理</span> </p><p><span style=\"font-family:宋体\">　　必须描述负责软件质量保证的机构、任务及其有关的职责。</span> </p><p><span style=\"font-family:宋体\">软件开发网</span></p><p>　　4.2.1<span style=\"font-family:宋体\">机构</span> </p><p><span style=\"font-family:宋体\">　　本条必须描述与软件质量保证有关的机构的组成。还必须清楚地描述来自项目委托单位、项目承办单位、软件开发单位或用户中负责软件质量保证的各个成员有机构中的相互关系。</span> </p><p>　　4.2.2<span style=\"font-family:宋体\">任务</span> <span style=\"font-family:宋体\">软件开发网</span> </p><p><span style=\"font-family:宋体\">　　本条必须描述计划涉及的软件生存周期中有关阶段的任务，特别要把重点放在描述这些阶段所应进行的软件质量保证活动上。</span><br/> 　　4.2.3<span style=\"font-family:宋体\">职责</span> </p><p><span style=\"font-family:宋体\">　　本条必须指明软件质量保证计划中规定的每一个负责单位或成员的责任。</span> </p><p>　　4.3<span style=\"font-family:宋体\">文档</span> </p><p><span style=\"font-family:宋体\">　　必须列出在该软件的开发、验证与确认以及使用与维护等阶段中需要编制的文档，并描述对文档进行评审与检查的准则。</span> </p><p>　　4.3.1<span style=\"font-family:宋体\">基本文档</span> </p><p><span style=\"font-family:宋体\">　　为了确保软件的实现满足需求，至少需要下列基本文档：</span> </p><p>　　4.3.1.1<span style=\"font-family:宋体\">软件需求规格说明书</span> software requirements specification</p><p><span style=\"font-family:宋体\">　　软件需求规格说明书必须清楚、准确地描述软件的每一个基本需求（功能、性能、设计约束和属性）和外部界面。必须把每一个需求规定成能够通过预先定义的方法（例如检查、分析、演示或测试等）被客观地验证与确认的形式。软件需求规格说明书的详细格式按</span>GB 8567<span style=\"font-family:宋体\">。</span> </p><p>　　4.3.1.2<span style=\"font-family:宋体\">软件设计说明书</span> software design description</p><p><span style=\"font-family:宋体\">　　软件设计说明书应该包括软件概要设计说明和软件详细设计说明两部分。其概要设计部分必须描述所设计的总体结构、外部接口、各个主要部件的功能与数据结构以及各主要部件之间的接口；必要时还必须对主要部件的每一个部件进行描述。其详细设计部分必须给出每一个基本部件的功能、算法和过程描述。软件设计说明书的详细格式按</span>GB8567<span style=\"font-family:宋体\">。</span> </p><p>　　4.3.1.3<span style=\"font-family:宋体\">软件验证与确认计划</span> software verification and validation plan http://www.mscto.com</p><p><span style=\"font-family:宋体\">　　软件验证与确认计划必须描述所采用的验证和确认方法（例如评审、检查、分析、演示或测试等），以用来验证软件需求规格说明书中的需求是否已由软件设计说明书描述的设计实现；软件设计说明书表达的设计是否已由编码实现。软件验证与确认计划还可用来确认编码的执行是否与软件需求规格说明书中所规定的需求相一致。软件验证与确认计划的详细格式按</span>GB 8567 <span style=\"font-family:宋体\">中的测试计划的格式。</span> </p><p>　　4.3.1.4<span style=\"font-family:宋体\">软件验证和确认报告</span> software verification and validation report</p><p><span style=\"font-family:宋体\">　　软件验证与确认报告必须描述软件验证与确认计划的执行结果。这里必须包括软件质量保证计划所需要的所有评审、检查和测试的结果。软件验证与确认报告的详细格式按</span>GB 8567 <span style=\"font-family:宋体\">中的测试报告的格式。</span> </p><p>4.3.1.5<span style=\"font-family: 宋体\">用户文档</span> user documentation</p><p><span style=\"font-family:宋体\">软件开发网</span></p><p><span style=\"font-family:宋体\">　　用户文档（例如手册、指南等到）必须指明成功运行该软件所需要的数据、控制命令以及运行条件等；必须指明所有的出错信息、含义及其修改方法；还必须描述将用户发现的错误或问题通知项目承办单位（或软件开发单）或项目委托单位的方法。用户文档的详细格式按</span>GB 8567<span style=\"font-family:宋体\">。</span> </p><p><span style=\"font-family:宋体\">软件开发网</span></p><p>　　4.3.2 <span style=\"font-family:宋体\">其他文档</span> </p><p><span style=\"font-family:宋体\">　　除基本文档以外，还应包括下列文档：</span> </p><p><span style=\"font-family:宋体\">　　项目实施计划（其中可包括软件配置管理计划，但在必要时也可单独制订该计划）：其详细格式按</span>GB 8567<span style=\"font-family:宋体\">。</span> </p><p><span style=\"font-family:宋体\">　　项目进展报表：其详细格式可参考本规范附录</span>B<span style=\"font-family:宋体\">（参考件）中有关《项目进展报表》的各项规定。</span> </p><p><span style=\"font-family:宋体\">　　项目开发各阶段的评审报表：其详细格式可参考本规范附录</span>C<span style=\"font-family:宋体\">（参考件）中有关《项目阶段评审表》的各项规定。</span> </p><p><span style=\"font-family:宋体\">　　项目开发总结：其详细格式按</span>GB 8567<span style=\"font-family:宋体\">。</span> </p><p><span style=\"font-family:宋体\">软件开发网</span></p><p>　　4.4<span style=\"font-family:宋体\">标准、条例和约定</span> </p><p><span style=\"font-family:宋体\">　　必须列出软件开发过程中要用到的标准、条例和约定，并列出监督和保证执行的措施。</span> </p><p><span style=\"font-family:宋体\">软件开发网</span></p><p>　　4.5<span style=\"font-family:宋体\">评审和检查</span> </p><p><span style=\"font-family:宋体\">　　必须规定所要进行的技术和管理两方面的评审和检查工作，并编制或引用有关的评审和检查规程以及通过与否的技术准则。至少要进行下列各项评审和检查工作：</span> </p><p>　　4.5.1<span style=\"font-family:宋体\">软件需求评审</span> software requirements review</p><p><span style=\"font-family:宋体\">　　在软件概要设计结束后必须进行概要设计评审，以确保在软件需求规格说明书中所规定的各项需求的合适性。</span> </p><p>　　4.5.2<span style=\"font-family:宋体\">概要设计评审</span> preliminary design review http://www.mscto.com</p><p><span style=\"font-family:宋体\">　　在软件概要设计结束后必须进行概要设计评审，以评价软件设计说明书中所描述的软件概要设计在总体结构、外部接口、主要部件功能分配、全局数据结构以及各主要部件之间的接口等方面的合适性。</span> http://www.mscto.com</p><p>　　4.5.3<span style=\"font-family:宋体\">详细设计评审</span> detailed design review</p><p><span style=\"font-family:宋体\">　　在软件详细设计阶段结束后必须进行详细设计评审，以评价软件验证与确认计划中所规定的验证与确认方法的合适性与完整性。</span> </p><p>　　4.5.5<span style=\"font-family:宋体\">功能检查</span> functional audit</p><p><span style=\"font-family:宋体\">　在软件释放前，要对软件进行物理检查，以验证程序和文档已经满足在软件需求说明书中规定的所有需求。</span> </p><p>　　4.5.6<span style=\"font-family:宋体\">物理检查</span> physical audit</p><p><span style=\"font-family:宋体\">　　在验收软件前，要对软件进行物理检查，以难程序和文档已经一致并已做好了交付的准备。</span> </p><p>　　4.5.7<span style=\"font-family:宋体\">综合检查</span> comprehensive audit</p><p><span style=\"font-family:宋体\">　　在软件验收时，要允许用户或用户所委托的专家对所要验收的软件进行设计抽样的综合检查，以验证代码和设计文档的一致性。</span> </p><p>　　4.5.8<span style=\"font-family:宋体\">管理评审</span> management reviews</p><p><span style=\"font-family:宋体\">　要对计划的执行情况定期（或按阶段）进行管理评审；这些评审必须由独立于被评审单位的机构或授权的第三方主持进行。</span> <span style=\"font-family:宋体\">软件开发网</span> </p><p>　　4.6<span style=\"font-family:宋体\">软件配置管理</span> </p><p><span style=\"font-family:宋体\">软件开发网</span></p><p><span style=\"font-family:宋体\">　　必须编制有关软件配置管理的条款，或引用按照</span>GB/T 12505<span style=\"font-family:宋体\">单独制订的文档。在这些条款或文档中，必须规定用于标识软件产品、控制和实现软件的修改、记录和报告修改实现的状态以及评审和检查配置工作等四方面的活动。还必须规定用以维护和存储软件受控版本的方法和设施；必须规定对所发现的问题进行报告、追踪和解决的步骤，并指出实现报告、追踪和解决软件问题的机构及其职责。</span> </p><p>　　4.7<span style=\"font-family:宋体\">工具、技术和方法</span> </p><p><span style=\"font-family:宋体\">　　必须指明用以支持特定软件项目质量保证工作的工具、技术和方法，指出它们的目的，描述它们的用途。</span></p><p>4.8<span style=\"font-family:宋体\">媒体控制</span> </p><p><span style=\"font-family:宋体\">　　必须指出保护计算机程序物理媒体的方法和设施，以免非法存取、意外损坏或自然老化。</span> </p><p>　　4.9<span style=\"font-family:宋体\">对供货单位的控制</span> </p><p><span style=\"font-family:宋体\">　　供货单位包括项目承办单位、软件销售单位或软件子开发单位。必须规定对这些供货单位进行控制和规程，从而保证项目承办单位从软件销售单位购买的、其他开发单位（或子开发单位）开发的或从开发（或子开发）单位现存软件库中选用的软件能满足规定的需求。</span> </p><p>　　4.10<span style=\"font-family:宋体\">记录的收集、维护和保存</span> </p><p><span style=\"font-family:宋体\">　　必须指明需要保存的软件质量保证活动的记录，并指出用于汇总、保护和维护这些记录的方法和设施，并指明要保存的期限。</span></p><p><br/></p>', b'0', NULL, 10000, '', NULL, 3, '深度学习', 9, 1567308280, 1567308280);
INSERT INTO `articles` VALUES (11, '这个是测试标题，测试一下文章类型', '<p>你好！</p><p><span style=\"font-family: 楷体, 楷体_GB2312, SimKai; font-size: 24px;\">这个是测试标题，测试一下文章类型</span></p><p><span style=\"font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\">这个是测试标题，测试一下文章类型</span></p><p style=\"text-align: center;\"><em><span style=\"font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\">这个是测试标题，测试一下文章类型</span></em></p><p style=\"text-align: right;\"><em><span style=\"font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\">这个是测试标题，测试一下文章类型</span></em></p><p style=\"text-align: left;\"><strong><span style=\"font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\">Goob boy</span></strong><em><span style=\"font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\"><br/></span></em></p><p style=\"text-align: left;\"><span style=\"background-color: rgb(255, 0, 0); color: rgb(79, 129, 189);\"><strong><span style=\"background-color: rgb(255, 0, 0); font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\">Goob boy</span></strong></span></p><p style=\"text-align: left;\"><span style=\"background-color: rgb(255, 0, 0); color: rgb(79, 129, 189);\"><strong><span style=\"background-color: rgb(255, 0, 0); font-family: 楷体, 楷体_GB2312, SimKai; font-size: 36px;\"><img src=\"http://img.baidu.com/hi/tsj/t_0001.gif\"/></span></strong></span></p><p><img src=\"http://img.baidu.com/hi/jx2/j_0058.gif\"/></p><p><img src=\"http://img.baidu.com/hi/bobo/B_0004.gif\"/></p>', b'0', '你好！这个是测试标题，测试一下文章类型这个是测试标题，测试一下文章类型这个是测试标题，测试一下文章类型这个是测试标题，测试一下文章类型Goob boyGoob boy', 10000, NULL, NULL, 3, '深度学习', 45, 1567318645, 1567848914);
INSERT INTO `articles` VALUES (18, '测试测试测试tinyMCE', '<p>测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE</p>\n<p><strong>测试测试测试tinyMCE</strong></p>\n<p><strong>测<span style=\"text-decoration: line-through;\">试测试测试tinyMCE</span></strong></p>\n<p><span style=\"background-color: #e67e23;\"><strong><span style=\"text-decoration: line-through;\">测试测试测试tinyMCE</span></strong></span></p>\n<pre class=\"language-cpp\"><code>/**\n    * 测试代码\n    */\nint main( int argc, void **argv )\n{\n    return 0;\n}</code></pre>', b'1', '测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE测试测试测试tinyMCE 测试测试测试tinyMCE 测试测试测试', 10000, NULL, NULL, 4, '视觉SLAM', 44, 1568641507, 1568641507);
INSERT INTO `articles` VALUES (33, '图片测试', '<p style=\"margin: 0cm 0cm 0.0001pt; text-align: justify; font-size: 10.5pt; font-family: 等线;\"><img src=\"\\static\\uploads\\images\\20190917\\02571221377ae8be2f9f04a1ddcc4a80.jpg\" width=\"554\" height=\"369\" /></p>', b'0', '', 10000, NULL, NULL, 3, '深度学习', 43, 1568727764, 1568727764);

-- ----------------------------
-- Table structure for carousels
-- ----------------------------
DROP TABLE IF EXISTS `carousels`;
CREATE TABLE `carousels`  (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '点击图片链接',
  `priority` int(20) NULL DEFAULT 99 COMMENT '优先级',
  `create_time` int(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of carousels
-- ----------------------------
INSERT INTO `carousels` VALUES (2, '轮播图测试', '/index/article/detial/id/34.html', 39, 1571909581);

-- ----------------------------
-- Table structure for cates
-- ----------------------------
DROP TABLE IF EXISTS `cates`;
CREATE TABLE `cates`  (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别名称',
  `priority` int(4) NOT NULL DEFAULT 99 COMMENT '优先级',
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `create_time` int(20) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cates
-- ----------------------------
INSERT INTO `cates` VALUES (3, '深度学习', 49, NULL, 0);
INSERT INTO `cates` VALUES (4, '视觉SLAM', 51, NULL, 0);
INSERT INTO `cates` VALUES (13, 'test', 60, NULL, NULL);

-- ----------------------------
-- Table structure for drafts
-- ----------------------------
DROP TABLE IF EXISTS `drafts`;
CREATE TABLE `drafts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章题目',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '文章内容',
  `abstract_is` bit(1) NULL DEFAULT NULL COMMENT '是否有摘要',
  `abstract` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章摘要',
  `author_id` int(11) NOT NULL COMMENT '作者id',
  `title_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章封面',
  `origin_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '来源Url',
  `cate_id` int(11) NULL DEFAULT NULL COMMENT '所属类别',
  `cate_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(20) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cate_id`(`cate_id`) USING BTREE,
  INDEX `cate_name`(`cate_name`) USING BTREE,
  CONSTRAINT `drafts_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `cates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `drafts_ibfk_2` FOREIGN KEY (`cate_name`) REFERENCES `cates` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of drafts
-- ----------------------------
INSERT INTO `drafts` VALUES (6, 'orb s', '<p>sdsa</p>', b'0', 'sdsa', 10000, NULL, '', 4, '视觉SLAM', 1571892873);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` int(11) NOT NULL COMMENT '主键',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES (1, '这是一条测试公告', '测试公告内容。测试公告内容。测试公告内容。测试公告内容。测试公告内容。测试公告内容。', 1568760112);
INSERT INTO `notifications` VALUES (2, '网站正在建设中,感谢关注~', '非常高兴您访问本网站，目前本网站正在建设中，同时本网站的代码已经开源，感兴趣的话可以移步到GitHub中查看详情，谢谢您的关注', 1568860112);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户昵称',
  `email` varchar(22) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户邮箱',
  `passwd` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登陆密码',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '自我介绍',
  `create_time` int(20) NOT NULL COMMENT '注册时间',
  `this_login_time` int(20) NOT NULL COMMENT '本次登陆时间',
  `last_login_time` int(20) NULL DEFAULT NULL COMMENT '上次登陆时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (10000, '测试', 'test@test.com', '058f403c565f4583', '秋风别叶，叶念西风!', 1567308280, 1573108018, 1573107912);

SET FOREIGN_KEY_CHECKS = 1;
