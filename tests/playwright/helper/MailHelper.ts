import { expect, Locator, Page } from "@playwright/test";
import Input from "@hipanel-core/input/Input";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";
import Select2 from "@hipanel-core/input/Select2";

export default class MailHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexMail() {
        await this.page.goto('/hosting/mail/index');
        await expect(this.page).toHaveTitle("Mailboxes");
    }

    async gotoCreateMail() {
        await this.page.locator('text=Create mailbox').click();
    }

    async gotoMailPage( ip: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('IP', ip, false);
        await this.page.locator('tr td button').nth(rowNumber + 1).click();
        await this.page.locator('div[role="tooltip"] >> text=View').click();
    }

    async seeMailStatus(account: string, status: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('E-mail', account);
        const accountStatus = await this.index.seeTextOnTable('Status', rowNumber, status);
    }

    async checkDetailViewData(ip: object) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[1]/td')).toContainText(ip['ip']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[5]/td')).toContainText(ip['links']);
    }

    async delete() {
        this.page.on('dialog', dialog => dialog.accept());
        await this.index.clickBulkButton('Delete');
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }

    async save() {
        await this.page.locator("text=Save").click();
    }
}
