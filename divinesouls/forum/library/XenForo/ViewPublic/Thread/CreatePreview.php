<?php

class XenForo_ViewPublic_Thread_CreatePreview extends XenForo_ViewPublic_Base
{
	public function renderHtml()
	{
		$bbCodeParser = new XenForo_BbCode_Parser(XenForo_BbCode_Formatter_Base::create('Base', array('view' => $this)));
		$this->_params['messageParsed'] = new XenForo_BbCode_TextWrapper($this->_params['message'], $bbCodeParser);
	}
}