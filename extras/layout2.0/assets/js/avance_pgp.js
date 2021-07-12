function progressBar(percent, element) {
	var progressBarWidth = percent * element.width() / 100;
	element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
}


progressBar(45, $('.progressBar1'));
progressBar(75, $('.progressBar2'));
progressBar(100, $('.progressBar3'));
progressBar(67, $('.progressBar4'));
progressBar(67, $('.progressBar5'));
progressBar(67, $('.progressBar6'));
progressBar(60, $('.progressBar7'));
progressBar(45, $('.progressBar8'));