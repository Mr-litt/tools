<?php
/**
 * Created by PhpStorm.
 * User: lqq
 * Date: 2016/07/18
 * Time: 11:11
 */
class Excel
{
	private $header = "<?xml version=\"1.0\" encoding=\"%s\"?\>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
	private $coding;
	private $type;
	private $tWorksheetTitle;
	private $filename;

	/**
	 * Excel基础配置
	 * @param string $enCoding 编码
	 * @param boolean $boolean 转换类型
	 * @param string $title 表标题
	 * @param string $filename Excel文件名
	 */
	public function config($enCoding,$boolean,$title,$filename){
		//编码
		$this->coding=$enCoding;
		//转换类型
		if($boolean==true){
			$this->type='Number';
		}else{
			$this->type='String';
		}
		//表标题
		$title=preg_replace('/[\\\|:|\/|\?|\*|\[|\]]/', '', $title);
		$title = substr ($title, 0, 30);
		$this->tWorksheetTitle=$title;
		//文件名
		$filename=preg_replace('/[^aA-zZ0-9\_\-]/', '', $filename);
		$this->filename=$filename;
	}

	//循环输出行
	public function addRow($data){
		$cells='';
		foreach ($data as $key => $val){
			$type=$this->type;
			//字符转换为 HTML 实体
			$val=htmlentities($val,ENT_COMPAT,$this->coding);
			$cells.="<Cell><Data ss:Type=\"$type\">" . $val . "</Data></Cell>\n";
		}
		return $cells;
	}

	//生成excel
	public function excelXls($data){
		header("Content-Type: application/vnd.ms-excel; charset=" . $this->coding);
		header("Content-Disposition: inline; filename=\"" . $this->filename . ".xls\"");
		/*打印*/
		echo stripslashes (sprintf($this->header, $this->coding));
		echo "\n<Worksheet ss:Name=\"" . $this->tWorksheetTitle . "\">\n<Table>\n";
		foreach ($data as $key => $val){
			$rows=$this->addRow($val);
			echo "<Row>\n".$rows."</Row>\n";
		}
		echo "</Table>\n</Worksheet>\n";
		echo "</Workbook>";
	}

}