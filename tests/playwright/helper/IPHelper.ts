import { expect, Locator, Page } from "@playwright/test";
import Input from "@hipanel-core/input/Input";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";
import Select2 from "@hipanel-core/input/Select2";

export default class IPHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexIP() {
        await this.page.goto('/hosting/ip/index');
        await expect(this.page).toHaveTitle("IP addresses");
    }

    async gotoCreateIP() {
        await this.page.locator('text=Create IP').click();
    }

    async gotoIPPage( ip: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('IP', ip, false);
        await this.page.locator(`tr:nth-child(${rowNumber}) > .text-center`).click();
        await this.page.locator('div[role="tooltip"] >> text=View').click();
    }

    async gotoUpdateIPPage(ip: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('IP', ip, false);
        await this.page.locator(`tr:nth-child(${rowNumber}) > .text-center`).click();
        await this.page.locator('div[role="tooltip"] >> text=Update').click();
    }

    async updateTags(tag: string) {
        await Select2.field(this.page, '#ip-0-tags').setValue(tag);
    }

    async checkDetailViewData(ip: object) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[1]/td')).toContainText(ip['ip']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[5]/td')).toContainText(ip['links']);
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }

    async save() {
        await this.page.locator("text=Save").click();
    }
}
