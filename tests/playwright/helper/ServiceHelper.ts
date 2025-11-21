import { expect, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import { Alert } from "@hipanel-core/shared/ui/components";
import Select2 from "@hipanel-core/input/Select2";
import Dropdown from "@hipanel-core/input/Dropdown";

export default class ServiceHelper {
  private page: Page;
  private index: Index;

  public constructor(page: Page) {
    this.page = page;
    this.index = new Index(page);
  }

  async gotoIndexService() {
    await this.page.goto("/hosting/service/index");
    await expect(this.page).toHaveTitle("Services");
  }

  async gotoCreateService() {
    await this.page.locator("text=Create service").click();
  }

  async gotoServicePage(server: string) {
    const rowNumber = await this.index.getRowNumberInColumnByValue("Server", server, false);
    await this.page.locator("tr td button").nth(rowNumber - 1).click();
    await this.page.locator("div[role=\"tooltip\"] >> text=View").click();
  }

  async gotoUpdatePage(object: string) {
    const rowNumber = await this.index.getRowNumberInColumnByValue("Object", object, false);
    await this.page.locator("tr td button").nth(rowNumber - 1).click();
    await this.page.locator("div[role=\"tooltip\"] >> text=Update").click();
  }

  async updateData(service: object) {
    await Select2.field(this.page, `#service-0-ips`).setValue(service["ip"]);
    await Dropdown.field(this.page, `#service-0-state`).setValue(service["status"]);
  }

  async checkDetailViewData(service: object) {
    await expect(this.page.locator("//table[contains(@class, \"detail-view\")]//tbody/tr[2]/td")).toContainText(service.client);
    await expect(this.page.locator("//table[contains(@class, \"detail-view\")]//tbody/tr[3]/td")).toContainText(service.server);
  }

  async seeSuccessAlert(message: string) {
    await Alert.on(this.page).hasText(message);
  }

  async save() {
    await this.page.locator("text=Save").click();
  }
}
