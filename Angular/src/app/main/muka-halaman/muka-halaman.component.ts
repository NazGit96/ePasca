import { AfterViewInit, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import * as am4core from '@amcharts/amcharts4/core';
import * as am4maps from '@amcharts/amcharts4/maps';
import am4geodata_data_countries2 from '@amcharts/amcharts4-geodata/data/countries2';
import am4themes_animated from '@amcharts/amcharts4/themes/animated';
import * as am4charts from '@amcharts/amcharts4/charts';
am4core.useTheme(am4themes_animated);
import { NgbDateStruct, NgbCalendar } from '@ng-bootstrap/ng-bootstrap';
import { DashboardServiceProxy, RefBencanaServiceProxy, RefNegeriServiceProxy } from "../../shared/proxy/service-proxies";
// import { PengurusanMangsaComponent } from '../../pengurusan-mangsa/pengurusan-mangsa.component';

@Component({
  selector: 'app-muka-halaman',
  templateUrl: './muka-halaman.component.html',
  styleUrls: ['./muka-halaman.component.scss'],
  providers: [DashboardServiceProxy]
})
export class MukaHalamanComponent implements OnInit, AfterViewInit {
  ////////////////////////////////////////
  private polygonSeries: am4maps.MapPolygonSeries;/////////////////////////////

  filter: string;
  year: string;
  cardYear: string;
  arrayYear: any[];
  filterIdNegeri: number;
  filterIdBencana: number;
  filterYear: number;
  filterFromDate: any;
  fromDate: any;
  filterToDate: any;
  toDate: any;
  chooseFromDate = false;
  chartData: any[];
  mapData: any[];
  jumlahMangsa: any;
  jumlahIhsan: any;
  jumlahPinjaman: any;
  jumlahAntarabangsa: any;
  jumlahRumahBaikPulih: any;
  jumlahRumahKekal: any;
  jumlahPertanian: any;
  jumlahLain: any;
  bantuanCovidKematian: any;////////////////////////////////////////
  bantuanCovid100: any;/////////////////////////////////////////
  states: any;
  bencanaList: any;
  readonly DELIMITER = '-';
  //////////////////////////////////////////////
  showSeluruhMangsaNegeri = true;
  showKematianCovid = true;
  showBantuanKematianCovid = true;
  showPenerimaRM100 = true;
  showBantuanRM100 = true;
  // Add more boolean properties for other tooltip values as needed
  // pengurusanMangsaComponent: PengurusanMangsaComponent;//////////////////////////

  modelFooter: NgbDateStruct;
  today = this.calendar.getToday();

  public isCollapsed = false;
  public isCollapsedChart = false;

  constructor(
    private calendar: NgbCalendar,
    private router: Router,
    private _dashboardServiceProxy: DashboardServiceProxy,
    private _refBencanaServiceProxy: RefBencanaServiceProxy,
    private _refNegeriServiceProxy: RefNegeriServiceProxy
  ) {
    // this.pengurusanMangsaComponent = new PengurusanMangsaComponent();
  }

  ngOnInit(): void {

    this.cardDashboard();

    this.generateArrayOfYears();
    this.getNegeri();
    this.getBencana();

    this.filterYear = new Date().getFullYear();
  }

  ngAfterViewInit() {
    this.mapDashboard();
    this.chartDashboard();
  }

  cardDashboard() {
    this._dashboardServiceProxy.getJumlahBantuan(
      this.cardYear,
      this.filterIdBencana,
      this.filterFromDate,
      this.filterToDate
    ).subscribe((result) => {
      this.jumlahMangsa = result.jumlahMangsa;

      this.bantuanCovidKematian = result.bantuanCovidKematian;///////////////////////////////////////////

      this.bantuanCovid100 = result.bantuanCovid100;/////////////////////////////////////////////

      this.jumlahIhsan = result.bantuanBwi;

      this.jumlahPinjaman = result.bantuanPinjaman;

      this.jumlahAntarabangsa = result.bantuanAntarabangsa;

      this.jumlahRumahBaikPulih = result.bantuanRumahBaikPulih;

      this.jumlahRumahKekal = result.bantuanRumahKekal;

      this.jumlahPertanian = result.bantuanPertanian;

      this.jumlahLain = result.bantuanLain;

    });
  }
  /////////////////////////////////////////////
  /////////////////////////////////////////////
  toggleTooltipValue(value: string): void {
    // Update tooltip HTML based on the checkbox status
    switch (value) {
      case 'showSeluruhMangsaNegeri':
        this.showSeluruhMangsaNegeri = !this.showSeluruhMangsaNegeri;
        break;
      case 'showKematianCovid':
        this.showKematianCovid = !this.showKematianCovid;
        break;
      case 'showBantuanKematianCovid':
        this.showBantuanKematianCovid = !this.showBantuanKematianCovid;
        break;
      case 'showPenerimaRM100':
        this.showPenerimaRM100 = !this.showPenerimaRM100;
        break;
      case 'showBantuanRM100':
        this.showBantuanRM100 = !this.showBantuanRM100;
        break;
      // Add cases for other tooltip values as needed
    }
    this.updateTooltipHTML();
  }

  updateTooltipHTML(): void {
    // Construct the tooltip HTML based on checkbox status
    let tooltipHTML = `
      <div style="display: flex; flex-direction: column;">
        <div style="text-align: left;">
          {nama_negeri}
        </div>
    `;
    //////////////////////////////////
    /////////////////////////////////
    if (this.showSeluruhMangsaNegeri) {
      tooltipHTML += `
        <div style="display: flex; justify-content: space-between;">
          <div style="text-align: left;">
            Jumlah Seluruh Mangsa Negeri:
          </div>
          <div style="text-align: right;">
            {value}
          </div>
        </div>
      `;
    }
    if (this.showKematianCovid) {
      tooltipHTML += `
        <div style="display: flex; justify-content: space-between;">
          <div style="text-align: left;">
            Jumlah Kematian:
          </div>
          <div style="text-align: right;">
            {jumlahMangsaCovidKematian}
          </div>
        </div>
      `;
    }
    if (this.showBantuanKematianCovid) {
      tooltipHTML += `
        <div style="display: flex; justify-content: space-between;">
          <div style="text-align: left;">
            Kos Bantuan Kematian:
          </div>
          <div style="text-align: right;">
            RM{jumlahBantuanKematianCovid}
          </div>
        </div>
      `;
    }
    if (this.showPenerimaRM100) {
      tooltipHTML += `
        <div style="display: flex; justify-content: space-between;">
          <div style="text-align: left;">
            Jumlah Penerima RM100 Sehari: 
          </div>
          <div style="text-align: right;">
            {jumlahMangsaCovidRM100}
          </div>
        </div>
      `;
    }
    if (this.showBantuanRM100) {
      tooltipHTML += `
        <div style="display: flex; justify-content: space-between;">
          <div style="text-align: left;">
            Kos Bantuan RM100 Sehari: 
          </div>
          <div style="text-align: right;">
            RM{jumlahCovidRM100}
          </div>
        </div>
      `;
    }
    // Add more conditions for other tooltip values as needed
    tooltipHTML += `</div>`;
    // Update the tooltip HTML
    // You can implement this based on your specific chart library
    this.updateTooltip(tooltipHTML);
  }

  updateTooltip(tooltipHTML: string): void {
    const polygonTemplate = this.polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipHTML = tooltipHTML;
  }
  ////////////////////////////////////////////
  /////////////////////////////////////////////

  mapDashboard() {

    if (this.toDate) {
      this.changeDateToString();
    }

    this._dashboardServiceProxy.getJumlahMangsaBencanaByNegeri(this.filterIdNegeri, this.filterIdBencana, this.filterYear, this.filterFromDate, this.filterToDate)
      .subscribe((result) => {
        let stringData = JSON.stringify(result.items);
        this.mapData = JSON.parse(stringData);

        am4core.addLicense('CH265473272');
        am4core.addLicense('MP265473272');

        // Default map
        const defaultMap = 'usaAlbersLow';

        // calculate which map to be used
        let currentMap = defaultMap;
        let title = '';
        if (am4geodata_data_countries2['MY'] !== undefined) {
          currentMap = am4geodata_data_countries2['MY']['maps'][0];

          // add country title
          if (am4geodata_data_countries2['MY']['country']) {
            title = am4geodata_data_countries2['MY']['country'];
          }
        }

        // Create map instance
        const chart = am4core.create('chartdiv', am4maps.MapChart);

        chart.titles.create().text = title;

        // Set map definition
        chart.geodataSource.url = 'https://www.amcharts.com/lib/4/geodata/json/' + currentMap + '.json';

        // Set projection
        chart.projection = new am4maps.projections.Mercator();

        // Create map polygon series
        const polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
        chart.geodataSource.data = this.mapData;
        polygonSeries.data = chart.geodataSource.data;

        //Set min/max fill color for each area
        polygonSeries.heatRules.push({
          property: 'fill',
          target: polygonSeries.mapPolygons.template,
          min: chart.colors.getIndex(1).brighten(1),
          max: chart.colors.getIndex(1).brighten(-0.3)
        });

        // Make map load polygon data (state shapes and names) from GeoJSON
        polygonSeries.useGeodata = true;

        // Set up heat legend
        const heatLegend = chart.createChild(am4maps.HeatLegend);
        heatLegend.series = polygonSeries;
        heatLegend.align = 'right';
        heatLegend.width = am4core.percent(25);
        heatLegend.marginRight = am4core.percent(4);
        heatLegend.minValue = 0;
        heatLegend.maxValue = 40000000;
        heatLegend.valign = 'bottom';

        // Set up custom heat map legend labels using axis ranges
        const minRange = heatLegend.valueAxis.axisRanges.create();
        minRange.value = heatLegend.minValue;
        minRange.label.text = 'Rendah';
        const maxRange = heatLegend.valueAxis.axisRanges.create();
        maxRange.value = heatLegend.maxValue;
        maxRange.label.text = 'Tinggi';

        // Blank out internal heat legend value axis labels
        heatLegend.valueAxis.renderer.labels.template.adapter.add('text', function (labelText) {
          return '';
        });

        // Configure series tooltip
        // const polygonTemplate = polygonSeries.mapPolygons.template;
        const polygonTemplate = this.polygonSeries.mapPolygons.template;
        polygonTemplate.tooltipHTML = `
      <div style="display: flex; flex-direction: column;">
      <div style="text-align: left;">
        {nama_negeri}
      </div>
      <div style="display: flex; justify-content: space-between;">
        <div style="text-align: left;">
          Jumlah Seluruh Mangsa Negeri: 
        </div>
        <div style="text-align: right;">
          {value}
        </div>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <div style="text-align: left;">
          Jumlah Kematian: 
        </div>
        <div style="text-align: right;">
          {jumlahMangsaCovidKematian}
        </div>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <div style="text-align: left;">
          Kos Bantuan Kematian: 
        </div>
        <div style="text-align: right;">
          RM{jumlahBantuanKematianCovid}
        </div>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <div style="text-align: left;">
          Jumlah Penerima RM100 Sehari: 
        </div>
        <div style="text-align: right;">
          {jumlahMangsaCovidRM100}
        </div>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <div style="text-align: left;">
          Kos Bantuan RM100 Sehari: 
        </div>
        <div style="text-align: right;">
          RM{jumlahCovidRM100}
        </div>
      </div>
    </div>
  `;
        polygonTemplate.nonScalingStroke = true;
        polygonTemplate.strokeWidth = 0.5;

        ////////////////////////////////////////////
        // Add click event handler to map polygons
        // polygonTemplate.events.on('hit', (event) => {
        //   const stateName = (event.target.dataItem.dataContext as any).nama_negeri;

        //   console.log('polygonTemplate.events.on - stateName:', stateName);

        //   this.navigateToPengurusanMangsaPage(stateName);
        // });
        //////////////////////////////////

        // Create hover state and set alternative fill color
        const hs = polygonTemplate.states.create('hover');
        hs.properties.fill = chart.colors.getIndex(1).brighten(-0.5);

        polygonSeries.exclude = ["BN"];

      })
  }

  //////////////////////////////////////////
  // EDITING CLICK MAP
  // Method to navigate to "senarai" page with selected state as filter
  // navigateToPengurusanMangsaPage(stateName: string) {
  //   this.router.navigate(['/app/mangsa/senarai'], { queryParams: { negeri: stateName } });

  //   let filterValue = stateName;

  //   console.log('navigateToPengurusanMangsaPage - filterValue:', filterValue);

  //   // this.pengurusanMangsaComponent.applyFilter(filterValue);
  // }
  ////////////////////////////////////////////////

  chartDashboard() {

    this._dashboardServiceProxy.getJumlahBantuanByNegeri(
      this.year,
      this.filterIdBencana,
      this.filterFromDate,
      this.filterToDate
    ).subscribe((result) => {
      let stringData = JSON.stringify(result.items);
      this.chartData = JSON.parse(stringData);

      // Create chart instance
      var chart = am4core.create("chartdiv2", am4charts.XYChart);

      // Add data
      chart.data = this.chartData;

      // Create axes
      let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "nama_negeri";
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.grid.template.disabled = true;

      let label = categoryAxis.renderer.labels.template;
      label.truncate = true;
      label.tooltipText = "{nama_negeri}";

      categoryAxis.events.on("sizechanged", function (ev) {
        let axis = ev.target;
        let cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
        axis.renderer.labels.template.maxWidth = cellWidth;
      });

      // First value axis
      let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Bilangan Mangsa";
      valueAxis.renderer.grid.template.disabled = true;

      // Second value axis
      let valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis2.title.text = "Jumlah Bantuan";
      valueAxis2.renderer.opposite = true;
      valueAxis2.renderer.grid.template.disabled = true;

      // First series
      let series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "bilMangsa";
      series.dataFields.categoryX = "nama_negeri";
      series.name = "Bilangan";
      series.tooltipText = "{name}: [bold]{valueY}[/]";

      // Second series
      let series2 = chart.series.push(new am4charts.LineSeries());
      series2.dataFields.valueY = "jumlahBantuan";
      series2.dataFields.categoryX = "nama_negeri";
      series2.name = "Jumlah Bantuan (RM)";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.strokeWidth = 3;
      series2.yAxis = valueAxis2;

      // Add legend
      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
    });
  }

  toModel(date: NgbDateStruct | null): string | null {
    return date ? date.year + this.DELIMITER + date.month + this.DELIMITER + date.day : null;
  }

  getNegeri(filter?) {
    this._refNegeriServiceProxy.getRefNegeriForDropdown(filter).subscribe((result) => {
      this.states = result.items;
    });
  }

  getBencana(filter?) {
    this._refBencanaServiceProxy.getRefBencanaForDropdown(filter).subscribe((result) => {
      this.bencanaList = result.items;
    });
  }

  generateArrayOfYears() {
    let max = new Date().getFullYear();
    let min = max - 9;
    let years = [];

    for (let i = max; i >= min; i--) {
      years.push(i)
    }
    this.arrayYear = years;
  }

  pilihTarikhMula() {
    this.chooseFromDate = true;
    if (this.fromDate == null) {
      this.chooseFromDate = false;
      this.toDate = null;
    }
  }

  changeDateToString() {
    this.filterFromDate = this.toModel(this.fromDate);
    this.filterToDate = this.toModel(this.toDate);
  }

  resetMap() {
    this.filterIdBencana = undefined;
    this.filterIdNegeri = undefined;
    this.fromDate = undefined;
    this.toDate = undefined;
    this.filterYear = undefined;
    this.cardYear = undefined;
    this.year = undefined;

    this.chartDashboard();

    this.mapDashboard();
  }

  findFilter() {

    this.cardYear = String(this.filterYear);
    this.year = String(this.filterYear);

    this.chartDashboard();
    this.mapDashboard();
    this.cardDashboard();
  }

  resetGraph() {
    this.year = undefined;

    this.chartDashboard();
  }

}

