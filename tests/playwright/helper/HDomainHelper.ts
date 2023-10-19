import { expect, Locator, Page } from "@playwright/test";
import Input from "@hipanel-core/input/Input";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";

export default class HDomainHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexDomain() {
        await this.page.goto('/hosting/hdomain/index');
        await expect(this.page).toHaveTitle("Domains");
    }

    async gotoCreateDomain() {
        await this.page.locator('#dropdownMenu1').click();
        await this.page.locator('text=Create domain >> nth=1').click();
    }

    async gotoDomainPage(domain: string) {
        await this.index.clickLinkOnTable('Domain name', domain);
    }

    async checkDetailViewData(domainView: object) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[1]/td')).toContainText(domainView['client']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[2]/td')).toContainText(domainView['reseller']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[3]/td')).toContainText(domainView['account']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[4]/td')).toContainText(domainView['server']);
    }

    async confirmEnableBlock() {
        await Input.field(this.page, 'input[name="comment"]').fill("Test enable comment");
        await this.index.clickButton('Block');
        await this.page.waitForLoadState('networkidle');
    }

    async confirmDisableBlock() {
        await Input.field(this.page, 'input[name="comment"]').fill("Test unblock comment");
        await this.index.clickButton('Unblock');
        await this.page.waitForLoadState('networkidle');
    }

    async confirmDelete() {
        await this.index.clickButton('Delete');
    }

    async seeHdomainStatus(domain: string, status: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('Domain name', domain);
        const accountStatus = await this.index.seeTextOnTable('Status', rowNumber, status);
    }

    async delete() {
        this.page.on('dialog', dialog => dialog.accept());
        await this.index.clickBulkButton('Delete');
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }
}
