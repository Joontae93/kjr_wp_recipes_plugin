/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import { select } from "@wordpress/data";
import { useState } from "@wordpress/element";
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { title } = select("core/editor").getCurrentPost();
	function updateUrl({ target }) {
		console.log(target.value);
		console.log(attributes);
		setAttributes({ ...attributes, source_url: target.value });
	}
	// const allowedBlocks = ['core/']
	return (
		<div className="kjr-recipe" {...useBlockProps()}>
			<header className="kjr-recipe-header">
				<h2
					className="kjr-recipe__title"
					dangerouslySetInnerHTML={{
						__html: title,
					}}
				/>
				<div className="is-public">
					<span
						className="is-public__instructions"
						style={{ display: "block" }}
					>
						Check this box to add a link to the original recipe.
					</span>
					<input
						type="checkbox"
						name="public"
						id="public"
						checked={attributes.is_publicly_available}
						onChange={() => {
							setAttributes({
								...attributes,
								is_publicly_available: !attributes.is_publicly_available,
							});
						}}
					/>

					<label htmlFor="public">Recipe Has Link?</label>

					{attributes.is_publicly_available && (
						<input
							type="text"
							name="source_url"
							id="source_url"
							value={attributes.source_url}
							onChange={updateUrl}
							className="is-public__link"
							placeholder="https://example.com"
						/>
					)}
				</div>
			</header>
			<section className="recipe">
				<div className="recipe-ingredients">{attributes.ingredients}</div>
				<div className="recipe-instructions">{attributes.instructions}</div>
			</section>
			<InnerBlocks />
		</div>
	);
}
